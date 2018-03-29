<span><?php   $date1 = date('Y-m-d H:i:s', strtotime($datedd));

        $date2 = date("Y-m-d H:i:s");
        
        /* $dated1 =new Carbon\Carbon($datedd);
         $dated2 = new Carbon\Carbon();
*/
        $diff = abs(strtotime($date2) - strtotime($date1));
        
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        $times=abs(strtotime($date2)-strtotime($date1));
        $gettimepost = date('h:i A', strtotime($date1));
        if($days==0){
            $days=$times;
            if($times<60)
            {
                $days=$times." seconds";
            }elseif($times<3600){
                $checkminuts=floor($times/60);
                if($checkminuts<59){
                        $days=$checkminuts."  minutes";
                }else{
                $days="about an hours";
               }
        
            }else{
                $checkminuts=floor($times/3600);
                $days=$checkminuts." hrs";
            }
            
        }elseif($days==1) {
               $days='Yesterday at '.$gettimepost;
        }elseif($days>1){
                if($years==0){
                $days=date('d M', strtotime($date1))." at ".$gettimepost;
               }else{
                $days=date('d-m-y h:i A', strtotime($date1))." at ".$gettimepost;
               }
            }
            print_r($days);

?>
</span>