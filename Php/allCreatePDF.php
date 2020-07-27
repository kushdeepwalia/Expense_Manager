<?php
    require("../fpdf/pdf-sector.php");
    session_start();
    $username=$_SESSION['username'];
    $wallet=$_SESSION['wallet'];
    $email=$_SESSION['email'];
    $filename=$wallet;
    $filename.=".pdf";

    $con=mysqli_connect('localhost','root','');
    mysqli_select_db($con,$username) or die("Could connect to the database");

    $query=mysqli_query($con,"SELECT * FROM `$wallet`");

    if(mysqli_num_rows($query)>0)
    {
        $query2=mysqli_query($con,"SELECT * FROM `$wallet` WHERE `Category`='Expense'");
        $query3=mysqli_query($con,"SELECT * FROM `$wallet` WHERE `Category`='Expense'");
        $exp_tot=mysqli_query($con,"SELECT Sum(Amount) FROM `$wallet` WHERE `Category`='Expense'");
        $exp_result=mysqli_fetch_array($exp_tot);
        $exp_tot_sub=mysqli_query($con,"SELECT `Sub Category`,Sum(Amount) FROM `$wallet` WHERE `Category`='Expense' GROUP BY `Sub Category`");

        $pdf=new PDF_SECTOR();
        $pdf->AddPage();
        $pdf->SetLeftMargin(6);
        $pdf->SetRightMargin(5);
        $pdf->Cell(12);
        getimagesize("../Images/main-logo.png");
        $pdf->Image('../Images/main-logo.png',10,10,11,11);
        $pdf->SetFont("Arial","B","23");
        $pdf->setTextColor(0,0,0);
        $pdf->Cell(73,11,"Expense Manager","0","1","C");
        $pdf->Ln(5);

        $pdf->SetFont("Arial","B","18");
        $pdf->Cell(38,11,"Username : ","0","0","C");
        $pdf->SetFont("Arial","","16");
        $pdf->Cell(38,11,$username,"0","1");
        $pdf->SetFont("Arial","B","18");
        $pdf->Cell(23,11,"Email : ","0","0");
        $pdf->SetFont("Arial","","16");
        $pdf->Cell(98,11,$email,"0","1");
        $pdf->SetFont("Arial","B","18");
        $pdf->Cell(25,11,"Wallet : ","0","0");
        $pdf->SetFont("Arial","","16");
        $pdf->Cell(40,11,$wallet,"0","1");
        $pdf->Ln(4);
        
        //mreged cell
        $pdf->SetFont("Arial","B","16");
        $pdf->Cell(198,10,"All Transactions","0","1","C");
        
        //table column names
        $pdf->SetFont("Arial","B","16");
        $pdf->setTextColor(0,0,0);
        $pdf->Cell(20,10,"S. No.","1","0","C");
        $pdf->Cell(30,10,"Category","1","0","C");
        $pdf->Cell(23,10,"Amount","1","0","C");
        $pdf->Cell(32,10,"Sub-Cat.","1","0","C");
        $pdf->Cell(28,10,"Date","1","0","C");
        $pdf->Cell(35,10,"Description","1","0","C");
        $pdf->Cell(30,10,"Mode","1","1","C");

        $i=1;
        $pdf->SetFont("Arial","","12");
        while($result=mysqli_fetch_array($query))
        {
            $pdf->setTextColor(0,0,0);
            $pdf->Cell(20,10,$i++,"1","0","C");
            $pdf->Cell(30,10,$result[1],"1","0","C");
            $pdf->Cell(23,10,$result[2],"1","0","C");
            $pdf->Cell(32,10,$result[3],"1","0","C");
            $pdf->Cell(28,10,$result[4],"1","0","C");
            $pdf->Cell(35,10,$result[5],"1","0","C");
            $pdf->Cell(30,10,$result[6],"1","1","C");
        }

        if(mysqli_num_rows($query2)>0)
        {
            $pdf->AddPage();
            $pieX=103;
            $pieY=70;
            $r=45;
            $legendX=160;
            $legendY=30;
            $degunit=360/$exp_result[0];
            $exp_res_sub_tot=mysqli_fetch_all($exp_tot_sub);
            $currentAngle=0;
            $i=0;
            while($i<mysqli_num_rows($query2))
            {
                switch($exp_res_sub_tot[$i][0])
                {
                    case "Bills":               $color=[223,32,32]; //Red 
                                                break;
                    case "Business":            $color=[249,249,6]; //Yellow
                                                break;
                    case "Education":           $color=[255,153,90]; //Peach
                                                break;
                    case "Entertainment":       $color=[0,153,255]; //Light Blue 
                                                break;
                    case "Family":              $color=[20,184,20]; //Green
                                                break;
                    case "Fees":                $color=[117,77,179]; //Purple
                                                break;
                    case "Food & Drinks":       $color=[3,3,99]; //Deep Blue
                                                break;
                    case "Friends & Lover":     $color=[255,102,140]; //Pink
                                                break;
                    case "Gifts":               $color=[0,153,153]; //Teal
                                                break;
                    case "Health":              $color=[255,102,0]; //Orange
                                                break;
                    case "Insurance":           $color=[102,102,153]; //Move - Light Purple 
                                                break;
                    case "Investment":          $color=[32,32,22]; //Dark Grey
                                                break;
                    case "Others":              $color=[102,0,51]; //Magenta 
                                                break;
                    case "Shopping":            $color=[0,77,0]; //Dark Green
                                                break;
                    case "Transportation":      $color=[91,57,5]; //Brown 
                                                break;
                    case "Travel":              $color=[163,163,194]; //Light Grey
                                                break;
                    case "Withdrawal":          $color=[166,89,89]; //Dull Red
                                                break;
                }
                $deg[$i]=$degunit*$exp_res_sub_tot[$i][1];
                $pdf->SetFillColor($color[0],$color[1],$color[2]);
                $pdf->SetDrawColor($color[0],$color[1],$color[2]);
                $pdf->Sector($pieX,$pieY,$r,$currentAngle,$currentAngle+$deg[$i]);
                $currentAngle+=$deg[$i];
                $pdf->Rect($legendX,$legendY,5,5,"DF");
                $pdf->SetXY($legendX + 6,$legendY);
                $pdf->Cell(50,5,$exp_res_sub_tot[$i][0],0,0);
                $legendY+=8;
                $i+=1;
            }
            
            //merged cell
            $pdf->SetDrawColor(0,0,0);
            $pdf->setTextColor(0,0,0);
            $pdf->SetLeftMargin(58);
            $pdf->SetFont("Arial","B","16");
            $pdf->Cell(298,90,"","1","1","C");
            $pdf->Cell(94,15,"Category Wise","0","1","C");
            
            //table column names
            $pdf->SetFont("Arial","B","16");
            $pdf->setTextColor(0,0,0);
            $pdf->Cell(24,10,"S. No.","1","0","C");
            $pdf->Cell(42,10,"Sub-Cat.","1","0","C");
            $pdf->Cell(28,10,"Amount","1","1","C");

            $i=1;
            $pdf->SetFont("Arial","","12");
            while($res=mysqli_fetch_array($query3))
            {   
                $pdf->setTextColor(0,0,0);
                $pdf->Cell(24,10,$i++,"1","0","C");
                $pdf->Cell(42,10,$res[3],"1","0","C");
                $pdf->Cell(28,10,$res[2],"1","1","C");
            }
        }
        
        if(isset($_POST['all-view-online']))
            $pdf->output();
        if(isset($_POST['all-download']))
            $pdf->Output($filename,'D');
    }
    else
    {
        session_start();
        $_SESSION['all-total-error']="No Record";
        header("location:../account.php");
    }
?>