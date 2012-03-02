using System;
using System.Collections;
using System.Collections.Generic;
using System.Data;
using System.Data.Odbc;
using System.IO;
using System.Linq;
using System.Security.Cryptography;
using System.Text;
using System.Threading;

using MySQLDriverCS;
using System.Diagnostics;

namespace Scanner
{

    public class Program
    {
        static void Main(string[] args)
        {
            //Debugger.Launch();
            //MessageLogger mainLogger = new MessageLogger();
            //mainLogger.LogMessage();
            if (args.Length == 0)
            {

                // No args, this application is called by PhotoScanner service

                PhotoScanner myScanner = new PhotoScanner();
                myScanner.LookupAndProcessPhoto(@"C:\ftproot\albums", @"C:\xampp\htdocs\CutGallery\var\Gallery_Folder", @"C:\backuproot\albums");

            }
            else
            {
                // There are args, this application is called by php code
            }
        }
    }

    public class PhotoScanner
    {
        private delegate void MovePhotoDelegate(string source, string destination);
        private bool thumbIsEmpty;
        private DatabaseHelper mySqlHelper = null;
        IDictionary<string, string> item;
        private MessageLogger messageLogger = new MessageLogger(@"C:\PhotoScanner.txt");
        #region Constructor
        public PhotoScanner()
        {
            try
            {
                thumbIsEmpty = false;
                mySqlHelper = new DatabaseHelper("cutgallery", "root", "Admin123456");
                item = new Dictionary<string, string>();
                InitialItem(item);
            }
            catch (Exception ex)
            {
                messageLogger.LogMessage(ex.ToString());
            }
        }
        #endregion

        #region Private methods

        /// <summary>
        /// Resize the specified photo by path.
        /// </summary>
        /// <param name="path">Identifies the file.</param>
        private void ResizePhoto(string source, string destination)
        {
            try
            {
                double reszieWidth;
                double resizeHeight;
                PTImage.ZoomAuto(source, destination.Replace("Gallery_Folder", "resizes"), 640, 640, "", "", out resizeHeight, out reszieWidth);
                item["resize_height"] = resizeHeight.ToString();
                item["resize_width"] = reszieWidth.ToString();
            }
            catch (Exception ex)
            {
                messageLogger.LogMessage(ex.ToString());
            }
        }

        /// <summary>
        /// Create thumb for the specified photo by path.
        /// </summary>
        /// <param name="path">Identifies the file.</param>
        private void ThumbPhoto(string source, string destination)
        {
            try
            {
                double thumbWidth;
                double thumbHeight;
                PTImage.ZoomAuto(source, destination.Replace("Gallery_Folder", "thumbs"), 200, 200, "", "", out thumbHeight, out thumbWidth);
                item["thumb_height"] = thumbHeight.ToString();
                item["thumb_width"] = thumbWidth.ToString();
            }
            catch (Exception ex)
            {
                messageLogger.LogMessage(ex.ToString());
            }
        }

        /// <summary>
        /// Copy the specified photo from [oldPath] to [newPath].
        /// </summary>
        /// <param name="oldPath">Path to identify where a photo is.</param>
        /// <param name="newPath">Path to identify where a photo will be.</param>
        private void Copy(string source, string destination)
        {
            try
            {
                File.Copy(source, destination.Replace("Gallery_Folder", "albums"), true);
            }
            catch (Exception ex)
            {
                messageLogger.LogMessage(ex.ToString());
            }
        }

        /// <summary>
        /// Update CutGallery database: insert a new entry into "items" table for a photo.
        /// </summary>
        /// <param name="photo">A pair of column name and value of table "items".</param>
        private void UpdateDatabaseForPhoto(string file, IDictionary<string, string> photo)
        {
            try
            {
                string[] splittedPath = file.Split('\\');
                if (splittedPath.Length != 0 && splittedPath.Length > 2) // todo: need verification
                {
                    #region Gets album info
                    string albumName = splittedPath[splittedPath.Length - 2];
                    string photoName = splittedPath[splittedPath.Length - 1];
                    string titleName = photoName.Split('.')[0];
                    string where = "name = '" + albumName + "'";
                    IDictionary<string, string> album = new Dictionary<string, string>();
                    InitialItem(album);
                    mySqlHelper.Query("items", where, album);
                    #endregion Gets album info

                    #region Insert photo info

                    #region Update ptr
                    int albumLeftPtr = int.Parse(album["left_ptr"]);
                    int albumRightPtr = int.Parse(album["right_ptr"]);
                    if ((albumRightPtr - albumLeftPtr) == 1)
                    {
                        // This album is empty
                        photo["left_ptr"] = (albumLeftPtr + 1).ToString();
                    }
                    else
                    {
                        // This album is not empty..fuck
                        //photo["left_ptr"] = (albumRightPtr - 1).ToString();
                        photo["left_ptr"] = albumRightPtr.ToString();
                    }
                    photo["right_ptr"] = (int.Parse(photo["left_ptr"]) + 1).ToString();

                    string setLeftPtrSql = "left_ptr = (left_ptr + 2)";
                    string setRightPtrSql = "right_ptr = (right_ptr + 2)";
                    string whereLeftPtrSql = "right_ptr >= OLD_ALBUM_RIGHT_PTR AND left_ptr <> 1 AND left_ptr <> OLD_ALBUM_LEFT_PTR";
                    whereLeftPtrSql = whereLeftPtrSql.Replace("OLD_ALBUM_RIGHT_PTR", album["right_ptr"]);
                    whereLeftPtrSql = whereLeftPtrSql.Replace("OLD_ALBUM_LEFT_PTR", album["left_ptr"]);

                    string whereRightPtrSql = "right_ptr >= OLD_ALBUM_RIGHT_PTR";
                    whereRightPtrSql = whereRightPtrSql.Replace("OLD_ALBUM_RIGHT_PTR", album["right_ptr"]);
                    mySqlHelper.Update("items", setLeftPtrSql, whereLeftPtrSql);
                    mySqlHelper.Update("items", setRightPtrSql, whereRightPtrSql);
                    #endregion Update ptr

                    #region Insert this photo



                    photo["parent_id"] = album["id"];
                    photo["owner_id"] = album["owner_id"];
                    photo["relative_path_cache"] = albumName + "/" + photoName;
                    photo["name"] = photoName;
                    photo["relative_url_cache"] = albumName + "/" + titleName;
                    photo["slug"] = albumName;
                    photo["title"] = titleName;
                    photo["hashed_name"] = Utils.CalculateMD5Hash(photo["relative_path_cache"]);

                    mySqlHelper.Insert("items", photo);
                    if (thumbIsEmpty)
                    {
                        thumbIsEmpty = false;
                        //mySqlHelper.Insert("items", photo);
                        where = "relative_path_cache = '" + photo["relative_path_cache"] + "'";
                        mySqlHelper.Query("items", where, photo);
                        StringBuilder setStringBuilder = new StringBuilder();
                        setStringBuilder.Append("album_cover_item_id = '");
                        setStringBuilder.Append(photo["id"]);
                        setStringBuilder.Append("', ");
                        setStringBuilder.Append("thumb_height = '");
                        setStringBuilder.Append(photo["thumb_height"]);
                        setStringBuilder.Append("', ");
                        setStringBuilder.Append("thumb_width = '");
                        setStringBuilder.Append(photo["thumb_width"]);
                        setStringBuilder.Append("'");

                        where = "id = '" + photo["parent_id"] + "'";
                        mySqlHelper.Update("items", setStringBuilder.ToString(), where); //
                        thumbIsEmpty = false;
                    }
                    #endregion Insert this photo

                    #endregion Insert photo info
                }
            }
            catch (Exception ex)
            {
                messageLogger.LogMessage(ex.ToString());
            }
        }

        /// <summary>
        /// Cut the specified photo from [oldPath] to [newPath].
        /// </summary>
        /// <param name="oldPath">Path to identify where a photo is.</param>
        /// <param name="newPath">Path to identify where a photo will be.</param>
        /// <remarks>
        /// Actually, copy it to backup foler and then delete the file by Delete()
        /// </remarks>
        private void Cut(string source, string destination)
        {
            try
            {
                if (File.Exists(destination))
                {
                    File.Delete(destination);
                }

                File.Move(source, destination);
            }
            catch (Exception ex)
            {
                messageLogger.LogMessage(ex.ToString());
            }
        }

        /// <summary>
        /// Delete specified file
        /// </summary>
        /// <param name="source"></param>
        private void Delete(string source)
        {
            try
            {
                File.Delete(source);
            }
            catch (Exception ex)
            {
                messageLogger.LogMessage(ex.ToString());
            }
        }

        private void InitialItem(IDictionary<string, string> item)
        {
            item.Add("id", string.Empty); // default
            item.Add("album_cover_item_id", string.Empty);
            item.Add("captured", string.Empty);
            item.Add("created", string.Empty); // to test
            item.Add("description", string.Empty);
            item.Add("height", string.Empty); // to test
            item.Add("left_ptr", "0"); // to test
            item.Add("level", "3");
            item.Add("mime_type", "image/jpeg");
            item.Add("name", string.Empty);
            item.Add("hashed_name", string.Empty);
            item.Add("owner_id", string.Empty);
            item.Add("parent_id", string.Empty);
            item.Add("rand_key", string.Empty);
            item.Add("relative_path_cache", string.Empty);
            item.Add("relative_url_cache", string.Empty);
            item.Add("resize_dirty", string.Empty);
            item.Add("resize_height", string.Empty);
            item.Add("resize_width", string.Empty);
            item.Add("right_ptr", "0");
            item.Add("slug", string.Empty);
            item.Add("sort_column", "created");
            item.Add("sort_order", "ASC");
            item.Add("thumb_dirty", string.Empty);
            item.Add("thumb_height", string.Empty); // to test
            item.Add("thumb_width", string.Empty);
            item.Add("title", string.Empty);
            item.Add("type", "photo");
            item.Add("updated", string.Empty); // to test
            item.Add("view_count", "0");
            item.Add("weight", string.Empty); // to test
            item.Add("width", string.Empty); // to test
            item.Add("view_1", "0");
            item.Add("view_2", "0");
            item.Add("view_3", "1");
            item.Add("view_4", "1");
        }

        private bool IsPhotoOpened(string file)
        {
            bool result = false;
            FileStream fileStream = null;

            try
            {
                using (fileStream = File.OpenWrite(file))
                {
                    fileStream.Close();
                }
            }
            catch (Exception ex)
            {
                messageLogger.LogMessage(ex.ToString());
                result = true;
            }
            finally
            {
                if (fileStream != null)
                {
                    fileStream.Dispose();
                }
            }

            return result;
        }

        private bool IsPhotoInUse(string file)
        {
            bool inUse = false;
            FileStream fileStream = null;

            try
            {
                using (fileStream = new FileStream(file, FileMode.Open, FileAccess.ReadWrite, FileShare.None))
                {
                    if (fileStream.CanWrite)
                    {
                        inUse = false;
                    }
                    else
                    {
                        inUse = true;
                    }
                }
            }
            catch (Exception ex)
            {
                messageLogger.LogMessage(ex.ToString());
            }
            finally
            {
                if (fileStream != null)
                {
                    fileStream.Close();
                    fileStream.Dispose();
                }
            }

            return inUse;
        }


        #endregion Private methods

        #region Public methods

        public void LookupAndProcessPhoto(string source, string destination, string backup)
        {
            try
            {
                StringBuilder logStringBuilder = new StringBuilder();
                logStringBuilder.Append("Function LookupAndProcessPhoto: source is ");
                logStringBuilder.Append(source);
                logStringBuilder.Append(", destination is ");
                logStringBuilder.Append(destination);
                logStringBuilder.Append(", backup is ");
                logStringBuilder.Append(backup);
                messageLogger.LogMessage(logStringBuilder.ToString());

                if (Directory.Exists(source))
                {
                    string[] fileList = Directory.GetFileSystemEntries(source);

                    if (fileList.Length != 0)
                    {
                        foreach (string file in fileList)
                        {
                            if (Directory.Exists(file))
                            {
                                LookupAndProcessPhoto(file, destination + "\\" + Path.GetFileName(file), backup + "\\" + Path.GetFileName(file));
                            }
                            else
                            {
                                string[] imageTypes = { "255216", "7173", "6677", "13780" }; // 255216:jpg,7173:gif,6677:bmp,13780:png
                                byte[] buffur = null;

                                using (FileStream fileStream = new FileStream(file, FileMode.Open, FileAccess.Read))
                                {
                                    try
                                    {
                                        buffur = new byte[fileStream.Length];
                                        fileStream.Read(buffur, 0, 2);
                                    }
                                    catch (Exception exception)
                                    {
                                        // Log message here.
                                    }
                                    finally
                                    {
                                        if (fileStream != null)
                                        {
                                            fileStream.Close();
                                        }
                                    }
                                }

                                bool fileIsImage = imageTypes.Contains(string.Concat(buffur[0].ToString(), buffur[1].ToString()));
                                bool fileIsInUse = IsPhotoInUse(file);
                                bool fileIsOpened = IsPhotoOpened(file);

                                if (fileIsImage && !fileIsInUse && !fileIsOpened)
                                {
                                    // The file is a type of image: jpg, gif, bmp, png
                                    item = new Dictionary<string, string>();
                                    InitialItem(item);

                                    // 1. Resize image
                                    messageLogger.LogMessage("Resizing image...");
                                    MovePhotoDelegate delegate4Resize = new MovePhotoDelegate(ResizePhoto);
                                    IAsyncResult asyncResult4Resize = delegate4Resize.BeginInvoke(file, destination + "\\" + Path.GetFileName(file), null, null);
                                    delegate4Resize.EndInvoke(asyncResult4Resize);
                                    messageLogger.LogMessage("Image resized...");



                                    // 2. Check whether folder 'thumbs' is empty
                                    messageLogger.LogMessage("Check whether 'thumbs' folder is empty");
                                    string[] photoList = Directory.GetFileSystemEntries(destination.Replace("Gallery_Folder", "thumbs"));
                                    if (photoList.Length == 0)
                                    {
                                        thumbIsEmpty = true;
                                    }
                                    messageLogger.LogMessage("Thumb folder status: " + thumbIsEmpty.ToString());

                                    // 2. Create thumb
                                    messageLogger.LogMessage("Creating thumb...");
                                    MovePhotoDelegate delegate4Thumb = new MovePhotoDelegate(ThumbPhoto);
                                    IAsyncResult asyncResult4Thumb = delegate4Thumb.BeginInvoke(file, destination + "\\" + Path.GetFileName(file), null, null);
                                    delegate4Thumb.EndInvoke(asyncResult4Thumb);

                                    if (thumbIsEmpty)
                                    {
                                        string fileName = ".album" + Path.GetExtension(file);

                                        asyncResult4Thumb = delegate4Thumb.BeginInvoke(file, destination + "\\" + fileName, null, null);
                                        delegate4Thumb.EndInvoke(asyncResult4Thumb);

                                        
                                        asyncResult4Resize = delegate4Resize.BeginInvoke(file, destination + "\\" + fileName, null, null);
                                        delegate4Resize.EndInvoke(asyncResult4Resize);
                                    }
                                    messageLogger.LogMessage("Thumb created...");

                                    // 3. Copy
                                    messageLogger.LogMessage("Copyting image...");
                                    MovePhotoDelegate delegate4Copy = new MovePhotoDelegate(Copy);
                                    IAsyncResult asyncResult4Copy = delegate4Copy.BeginInvoke(file, destination + "\\" + Path.GetFileName(file), null, null);
                                    delegate4Copy.EndInvoke(asyncResult4Copy);
                                    messageLogger.LogMessage("Image copied...");

                                    // 4. Update db
                                    messageLogger.LogMessage("Updating database for photo...");
                                    UpdateDatabaseForPhoto(file, item);
                                    messageLogger.LogMessage("Table 'Items' updated...");

                                    // 5. Backup
                                    messageLogger.LogMessage("Backing up...");
                                    MovePhotoDelegate delegate4Cut = new MovePhotoDelegate(Cut);
                                    IAsyncResult asyncResult4Cut = delegate4Cut.BeginInvoke(file, backup + "\\" + Path.GetFileName(file), null, null);
                                    delegate4Cut.EndInvoke(asyncResult4Cut);
                                    messageLogger.LogMessage("Image has been saved...");
                                }
                                else
                                {
                                    // TODO: The file is not an image, log something here..
                                }
                            }
                        }
                    }
                    else
                    {
                        // Current folder is empty. 
                    }
                }
                else
                { }
            }
            catch (Exception ex)
            {
                messageLogger.LogMessage(ex.ToString());
            }
        }

        #endregion Public methods
    }

    public class DatabaseHelper
    {
        #region Consts
        private const string SQL_SELECT = "SELECT";
        private const string SQL_FROM = "FROM";
        private const string SQL_WHERE = "WHERE";
        private const string SQL_AND = "AND";
        private const string SQL_OR = "OR";
        private const string SQL_EQUAL = "=";
        private const string BLANK_SPACE = " ";
        #endregion Consts

        private string databaseName = string.Empty;
        private string username = string.Empty;
        private string password = string.Empty;
        private MessageLogger dbLogger = new MessageLogger(@"C:\PhotoScanner_Database.txt");
        private StringBuilder logStringBuilder = null;
        StringBuilder sqlCommnBuilder = null;
        private MySQLConnection conn = null;

        public DatabaseHelper(string database, string user, string pwd)
        {
            try
            {
                this.databaseName = database;
                this.username = user;
                this.password = pwd;

                logStringBuilder = new StringBuilder();
                logStringBuilder.Append("New slq connection: database Name is ");
                logStringBuilder.Append(databaseName);
                logStringBuilder.Append(", user name is ");
                logStringBuilder.Append(username);
                logStringBuilder.Append(", password is ");
                logStringBuilder.Append(password);
                dbLogger.LogMessage(logStringBuilder.ToString());
                conn = new MySQLConnection(new MySQLConnectionString(databaseName, username, password).AsString);
            }
            catch (Exception ex)
            {
                dbLogger.LogMessage(ex.ToString());
            }
        }

        public void Insert(string tableName, IDictionary<string, string> item)
        {
            MySQLCommand commn = null;

            try
            {
                List<string> columns = item.Keys.ToList<string>();
                List<string> values = item.Values.ToList<string>();


                for (int index = 0; index < values.Count; index++)
                {
                    if (string.IsNullOrEmpty(values[index]))
                    {
                        values.RemoveAt(index);
                        columns.RemoveAt(index);
                        index--;
                    }
                }

                sqlCommnBuilder = new StringBuilder();
                sqlCommnBuilder.Append("INSERT INTO ");
                sqlCommnBuilder.Append(tableName);
                sqlCommnBuilder.Append(" (");
                for (int index = 0; index < columns.Count; index++)
                {
                    sqlCommnBuilder.Append(columns[index]);
                    sqlCommnBuilder.Append(", ");
                }
                sqlCommnBuilder.Remove(sqlCommnBuilder.Length - 2, 2);
                sqlCommnBuilder.Append(") VALUES ('");
                for (int index = 0; index < values.Count; index++)
                {
                    sqlCommnBuilder.Append(values[index]);
                    sqlCommnBuilder.Append("', '");
                }
                sqlCommnBuilder.Remove(sqlCommnBuilder.Length - 4, 4);
                sqlCommnBuilder.Append("')");
                conn.Open();
                dbLogger.LogMessage(sqlCommnBuilder.ToString());
                commn = new MySQLCommand();
                commn.CommandType = CommandType.Text;
                commn.CommandText = sqlCommnBuilder.ToString();
                commn.Connection = conn;
                int id = commn.ExecuteNonQuery();
                int t = id;
            }
            catch (MySQLException mySQLException)
            {
                dbLogger.LogMessage(mySQLException.ToString());
            }
            finally
            {
                if (commn != null)
                {
                    commn.Dispose();
                }

                if (conn != null)
                {
                    conn.Close();
                    conn.Dispose();
                }
            }

        }

        public void Query(string tableName, string where, IDictionary<string, string> item)
        {
            MySQLCommand commn = null;
            MySQLDataReader mySqlReader = null;
            MySQLDataAdapter mySqlAdapter = null;
            try
            {
                conn.Open();
                dbLogger.LogMessage("Query columns from table: " + tableName);
                // Query table column name
                string[] columns = null;
                commn = new MySQLCommand();
                string queryString =
                    "SELECT column_name FROM information_schema.columns WHERE table_schema = 'DB_NAME' AND table_name = 'TABLE_NAME'";
                queryString = queryString.Replace("DB_NAME", databaseName);
                queryString = queryString.Replace("TABLE_NAME", tableName);
                commn.CommandText = queryString;
                commn.CommandType = CommandType.Text;
                commn.Connection = conn;
                mySqlAdapter = new MySQLDataAdapter(commn);
                DataSet myDataSet = new DataSet();
                mySqlAdapter.Fill(myDataSet);

                columns = new string[myDataSet.Tables[0].Rows.Count];

                for (int rowIndex = 0; rowIndex < myDataSet.Tables[0].Rows.Count; rowIndex++)
                {
                    columns[rowIndex] = myDataSet.Tables[0].Rows[rowIndex][0].ToString();
                }
                myDataSet.Clear();

                // Query table by where condition
                commn.Dispose();
                commn = new MySQLCommand();
                string queryString2 = "SELECT * FROM TABLE_NAME WHERE CONDITION";
                queryString2 = queryString2.Replace("TABLE_NAME", tableName);
                queryString2 = queryString2.Replace("CONDITION", where);
                commn.CommandText = queryString2;
                commn.CommandType = CommandType.Text;
                commn.Connection = conn;
                dbLogger.LogMessage(queryString2);
                mySqlAdapter = new MySQLDataAdapter(commn);
                myDataSet = new DataSet();
                mySqlAdapter.Fill(myDataSet);

                for (int columnIndex = 0; columnIndex < myDataSet.Tables[0].Columns.Count; columnIndex++)
                {
                    item[columns[columnIndex]] = myDataSet.Tables[0].Rows[0][columnIndex].ToString();
                }
            }
            catch (MySQLException mySqlException)
            {
                dbLogger.LogMessage(mySqlException.ToString());
            }
            finally
            {
                if (mySqlAdapter != null)
                {
                    mySqlAdapter.Dispose();
                }

                if (mySqlReader != null)
                {
                    mySqlReader.Close();
                    mySqlReader.Dispose();
                }

                if (commn != null)
                {
                    commn.Dispose();
                }

                if (conn != null)
                {
                    conn.Close();
                    conn.Dispose();
                }
            }
        }

        public void Update(string tableName, string set, string where)
        {
            MySQLCommand commn = null;

            try
            {
                string insertString = "UPDATE TABLE_NAME SET SET_CONDITION WHERE WHERE_CONDITION";
                insertString = insertString.Replace("TABLE_NAME", tableName);
                insertString = insertString.Replace("SET_CONDITION", set);
                insertString = insertString.Replace("WHERE_CONDITION", where);
                dbLogger.LogMessage(insertString);
                conn.Open();
                commn = new MySQLCommand();
                commn.CommandText = insertString;
                commn.CommandType = CommandType.Text;
                commn.Connection = conn;
                commn.ExecuteNonQuery();
            }
            catch (MySQLException mySqlException)
            {
                dbLogger.LogMessage(mySqlException.ToString());
            }
            finally
            {
                if (commn != null)
                {
                    commn.Dispose();
                }

                if (conn != null)
                {
                    conn.Close();
                    conn.Dispose();
                }
            }
        }

    }

    /// <summary>
    /// General utils
    /// </summary>
    public static class Utils
    {
        /// <summary>
        /// Calculate and return MD5 hashed code base on the input.
        /// </summary>
        /// <param name="input">String to be hashed.</param>
        /// <returns>Hashed string.</returns>
        public static string CalculateMD5Hash(string input)
        {

            MD5 md5 = MD5.Create();
            byte[] inputBytes = Encoding.ASCII.GetBytes(input);
            byte[] hash = md5.ComputeHash(inputBytes);

            StringBuilder md5HashStringBuilder = new StringBuilder();
            for (int i = 0; i < hash.Length; i++)
            {
                md5HashStringBuilder.Append(hash[i].ToString("x2"));
            }

            return md5HashStringBuilder.ToString();
        }
    }

    public class MessageLogger
    {
        public MessageLogger(string logFileName)
        {
            this.logFileName = logFileName;
        }

        private string logFileName = string.Empty;
        public void WriteLine(string message)
        {
            Console.WriteLine(message);
            LogMessage(message);
        }
        public void LogMessage(string message)
        {
            //string logFileName = ConfigurationManager.AppSettings["LogFileName"].ToString().Trim();
            if (!File.Exists(logFileName))
            {
                FileStream f = File.Create(logFileName);
                f.Close();
            }
            File.AppendAllText(logFileName, message + Environment.NewLine);
        }
    }
}
