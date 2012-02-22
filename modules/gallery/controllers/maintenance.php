<?php defined("SYSPATH") or die("No direct script access.");
class Maintenance_Controller extends Controller {
    public function index() {
        $template = new Theme_View("page.html");
        $template->content = new View("maintenance.html");
        print $template;
    }
    
    function Status($name)
    {
         $status=win32_query_service_status($name);
         echo "Service state is ";
         if ($status["CurrentState"]==1) {echo "Stopped";}
         else
         if ($status["CurrentState"]==2) {echo "Starting";}
         else
         if ($status["CurrentState"]==3) {echo "Stopping";}
         else
         if ($status["CurrentState"]==4) {echo "RUNNING";}
         echo "<br>";
         return $status["CurrentState"];
        /* SERVICE_STOPPED    = $1;
         SERVICE_START_PENDING       = $2;
         SERVICE_STOP_PENDING        = $3;
         SERVICE_RUNNING             = $4;
         SERVICE_CONTINUE_PENDING    = $5;
         SERVICE_PAUSE_PENDING       = $6;
         SERVICE_PAUSED              = $7; */
    }
    function StopOne($name)
    {
         echo "<h2>Restarting Service '".$name."'</h2>";
         $this->Status($name);
         echo "Sending Stop Command...";
         flush();
         $result=win32_stop_service($name);
         echo " (Result: ".$result.")<br>";
         $this->Status($name);
          // Sleeping and waiting for service to stop for maximum 50 seconds
         $count=0;
            do
            {
             flush();
           sleep(1);
           $count=$count+1;
           if ($count==10) {win32_stop_service($name);} //reissue stop command after 10 seconds
           if ($count==20) {win32_stop_service($name);} //reissue stop command after 20 seconds
           $laststate=$this->Status($name);
          }
         while (($laststate!=1) and ($count<50));
    }
    function StartOne($name)
    {
         echo "Sending Start Command... ";
         flush();
         $result=win32_start_service($name);
         echo "(Result: ".$result.")<br>";
         flush();
         // Sleeping and waiting for service to start for maximum 50 seconds
         $count=0;
            do
            {
             flush();
           sleep(1);
           $count=$count+1;
           if ($count==10) {win32_start_service($name);} //reissue stop command after 10 seconds
           if ($count==20) {win32_start_service($name);} //reissue stop command after 20 seconds
           $laststate=$this->Status($name);
          }
         while (($laststate!=4) and ($count<50));
         if ($laststate!=4)
         {
          Echo "ERROR: Service '".$name."' did not start, sending just one more start command";
          $result=win32_start_service($name); //give it one last try...
          }
    }

    function RestartOne($name)
    {
         echo "<h2>Restarting Service '".$name."'</h2>";
         $this->Status($name);
         echo "Sending Stop Command...";
         flush();
         $result=win32_stop_service($name);
         echo " (Result: ".$result.")<br>";
         $this->Status($name);
         // Sleeping and waiting for service to stop for maximum 50 seconds
         $count=0;
            do
            {
             flush();
           sleep(1);
           $count=$count+1;
           if ($count==10) {win32_stop_service($name);} //reissue stop command after 10 seconds
           if ($count==20) {win32_stop_service($name);} //reissue stop command after 20 seconds
           $laststate=$this->Status($name);
          }
         while (($laststate!=1) and ($count<50));
        echo "Sending Start Command... ";
         flush();
         $result=win32_start_service($name);
         echo "(Result: ".$result.")<br>";
         flush();
         // Sleeping and waiting for service to start for maximum 50 seconds
         $count=0;
            do
            {
             flush();
           sleep(1);
           $count=$count+1;
           if ($count==10) {win32_start_service($name);} //reissue stop command after 10 seconds
           if ($count==20) {win32_start_service($name);} //reissue stop command after 20 seconds
           $laststate=$this->Status($name);
          }
         while (($laststate!=4) and ($count<50));
         if ($laststate!=4)
         {
          Echo "ERROR: Service '".$name."' did not start, sending just one more start command";
          $result=win32_start_service($name); //give it one last try...
          }
    }
//StartOne("AntiVirService");
//Echo "<h3>Done. All OK</h3>";
}