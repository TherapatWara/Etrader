<?php
    $received = trim($_GET['order']);

    $con=mysqli_connect('localhost','root', '', 'ai');
        echo $received;
        $symbol[] = "";
        $ticket[] = 0;
        $profit[] = 0;
        $commit[] = 0;
        $status[] = 0;
        $pos = explode("|", $received);

        for($i=0;$i<count($pos)-1;$i++)
        {
            //echo $pos[$i]."**";
            $order=explode(",",$pos[$i]);
            //echo count($order);
            $symbol[$i]=$order[0];
            $ticket[$i]=$order[1];
            $profit[$i]=$order[2];
            $commit[$i]=$order[3];
            $status[$i]=$order[4];
            

        }

            if(mysqli_connect_error()){
                //echo '0';
                echo "Failer connected";
                echo mysqli_connect_error();
                }else{
                //if(mysqli_query($con,"TRUNCATE ai.history"))
                //{
                    for($i=0;$i<count($pos)-1;$i++)
                    {
                        if(mysqli_query($con, "INSERT INTO history (his_no, his_symbol, his_orderid, his_profit, his_commit, his_status) VALUES (NULL, '$symbol[$i]', '$ticket[$i]', '$profit[$i]', '$commit[$i]', $status[$i]);")){
                            //echo "2";
                            }else{
                            echo "Error: " . $sql . "<br>" . mysqli_error($con);
                            echo '0';
                        }
                    }
                    echo '1';
                //}else echo '0';
            }
            mysqli_close($con);
?>