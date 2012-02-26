using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Diagnostics;
using System.Threading;
using System.Security.Cryptography;

namespace Test
{
    public class MyScanner
    {
        Process myP = new Process();

        public MyScanner()
        {
            myP.StartInfo.FileName = @"D:\Scanner.exe";
        }

        public void TestTimer(Object stateInfo)
        {
            AutoResetEvent autoEvent = (AutoResetEvent)stateInfo;

            Console.WriteLine(DateTime.Now.ToString("h:mm:ss.fff"));
        }

        public void RunScanner()
        {
            myP.Start();

            for (int i = 0; i < 3; i++)
            {
                Thread.Sleep(1000);

            }
            Console.WriteLine(DateTime.Now.ToString());

            myP.CloseMainWindow();
        }

        public void StartScanner(Object stateInfo)
        {
            AutoResetEvent autoEvent = (AutoResetEvent)stateInfo;
            try
            {
                myP.Start();
                Console.WriteLine(DateTime.Now.ToString("h:mm:ss.fff"));
                Thread.Sleep(2000);

                
                myP.CloseMainWindow();
                myP.Close();
                autoEvent.Set();

            }
            catch (Exception ex)
            { }
            finally
            {
            }
        }

        public void StopScanner()
        {
            myP.Close();
        }

    }

    class Program
    {
        public delegate void TestDelegate();

        static void Main(string[] args)
        {

          
        }
    }
}
