<?php
$chknmap = exec("rpm -q nmap | awk 'BEGIN {FS=\" \"}; {print $4}'");

if($chknmap == 'not'){

exec("yum -y install nmap");

}else{
   echo "you already install nmap\n";
}
$dir = '/root/chkHTTPS';

if(is_dir($dir)){

echo "you already create chkHTTPS folder";

}else{

  mkdir ($dir);

}

$filename = "IPMIlist.csv" ;
$fopen = fopen($filename,'r');

if ($fopen == false)
{
    echo 'Open File fail';
    exit;
}
else
{
    $openNUM = 0;
    $filteredNUM = 0;
    $closedNUM = 0;
    $unfilteredNUM = 0;
    $hostdownNUM = 0;


   while (($data = fgetcsv($fopen,",")) !== false){
      $chkHTTPS = exec("nmap -p 443 ".$data[0]." | grep '443/tcp' | awk 'BEGIN {FS=\" \"}; {print $2}'");

 echo $chkHTTPS."\n";
      $ans = $data[0]."\n";

      switch ($chkHTTPS)
       {
          case "open":
            $openNUM += 1;
            $file = '/root/chkHTTPS/open-443.txt';
            $fp = @fopen($file,"a+")
                  or exit("開啟錯誤");
            if (fwrite($fp,$ans)){
               print "寫入檔案".$file."成功\n";
             }else {
                print "寫入檔案".$file."失敗\n";
             }
            fclose($fp);
            break;

          case "closed":
            $closedNUM += 1;
            $file = '/root/chkHTTPS/closed-443.txt';
            $fp = @fopen($file,"a+")
                  or exit("開啟錯誤");
            if (fwrite($fp,$ans)){
               print "寫入檔案".$file."成功\n";
           }else {
              print "寫入檔案".$file."失敗\n";
           }
           fclose($fp);
          break;

          case "filtered":
            $filteredNUM += 1;
            $file = '/root/chkHTTPS/filtered-443.txt';
            $fp = @fopen($file,"a+")
                  or exit("開啟錯誤");
            if (fwrite($fp,$ans)){
               print "寫入檔案".$file."成功\n";
           }else {
              print "寫入檔案".$file."失敗\n";
           }
           fclose($fp);
           break;

          case "unfiltered":
            $unfilteredNUM += 1;
            $file = '/root/chkHTTPS/unfiltered-443.txt';
            $fp = @fopen($file,"a+")
                  or exit("開啟錯誤");
            if (fwrite($fp,$ans)){
               print "寫入檔案".$file."成功\n";
           }else {
              print "寫入檔案".$file."失敗\n";
           }
           fclose($fp);
          break;

          default :
          $hostdownNUM += 1;
          $file = '/root/chkHTTPS/hostdown-443.txt';
          $fp = @fopen($file,"a+")
                  or exit("開啟錯誤");
            if (fwrite($fp,$ans)){
               print "寫入檔案".$file."成功\n";
           }else {
              print "寫入檔案".$file."失敗\n";
           }
           fclose($fp);
          break;

       }
     }
 }

    fclose($fopen);
    echo "OPEN: ".$openNUM."\n";
    echo "FILTER: ".$filteredNUM."\n";
    echo "CLOSED: ".$closedNUM."\n";
    echo "UNKNOWN: ".$unfilteredNUM."\n";
    echo "HOSTDOWN: ".$hostdownNUM."\n";
?>


