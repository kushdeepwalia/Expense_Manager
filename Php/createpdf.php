<?php
    require("../fpdf/pdf-sector.php");
    session_start();
    $username=$_SESSION['username'];
    $wallet=$_SESSION['wallet'];
    $filename=$wallet;
    $filename.=".pdf";
    $con=mysqli_connect('localhost:3306','id14247551_kush','9354752373_Kush');
    mysqli_select_db($con,$username) or die("Could connect to the database");
    $query=mysqli_query($con,"SELECT * FROM `$wallet`");
    $query1=mysqli_query($con,"SELECT * FROM `$wallet` WHERE `Category`='Income'");
    $query2=mysqli_query($con,"SELECT * FROM `$wallet` WHERE `Category`='Expense'");
    $in_tot=mysqli_query($con,"SELECT Sum(Amount) FROM `$wallet` WHERE `Category`='Income'");
    $in_result=mysqli_fetch_array($in_tot);
    $in_tot_sub=mysqli_query($con,"SELECT `Sub Category`,Sum(Amount) FROM `$wallet` WHERE `Category`='Income' GROUP BY `Sub Category`");
    $exp_tot=mysqli_query($con,"SELECT Sum(Amount) FROM `$wallet` WHERE `Category`='Expense'");
    $exp_result=mysqli_fetch_array($exp_tot);
    $exp_tot_sub=mysqli_query($con,"SELECT `Sub Category`,Sum(Amount) FROM `$wallet` WHERE `Category`='Expense' GROUP BY `Sub Category`");
    $pdf=new PDF_SECTOR();
    $pdf->AddPage();
    $pdf->SetFont("Arial","B","16");
    $pdf->setTextColor(252,3,3);
    $pdf->Cell(200,20,"All Records","0","2","C");
    //table column
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
    $pdf->AddPage();
    $pieX=105;
    $pieY=70;
    $r=40;
    $legendX=160;
    $legendY=30;
    $degunit=360/$in_result[0];
    $in_res_sub_tot=mysqli_fetch_all($in_tot_sub);
    $currentAngle=0;
    $i=0;
    $pdf->SetXY($pieX-24,$pieY-59);
    $pdf->Cell(200,5,"Monthly Income Report",0,0);
    while($i<mysqli_num_rows($query1)-1)
    {
        $color[0]=rand(0,255);
        $color[1]=rand(0,255);
        $color[2]=rand(0,255);    
        $deg[$i]=$degunit*$in_res_sub_tot[$i][1];
        $pdf->SetFillColor($color[0],$color[1],$color[2]);
        $pdf->SetDrawColor($color[0],$color[1],$color[2]);
        $pdf->Sector($pieX,$pieY,$r,$currentAngle,$currentAngle+$deg[$i]);
        $currentAngle+=$deg[$i];
        $pdf->Rect($legendX,$legendY,5,5,"DF");
        $pdf->SetXY($legendX + 6,$legendY);
        $pdf->Cell(50,5,$in_res_sub_tot[$i][0],0,0);
        $legendY+=8;
        $i+=1;
    }
    $pieX=105;
    $pieY=190;
    $r=40;
    $legendX=160;
    $legendY=150;
    $degunit=360/$exp_result[0];
    $exp_res_sub_tot=mysqli_fetch_all($exp_tot_sub);
    $currentAngle=0;
    $i=0;
    $pdf->SetXY($pieX-24,$pieY-59);
    $pdf->Cell(200,5,"Monthly Expense Report",0,0);
    while($i<mysqli_num_rows($query2)-1)
    {
        $color[0]=rand(0,255);
        $color[1]=rand(0,255);
        $color[2]=rand(0,255); 
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
    if(isset($_POST['view-online']))
        $pdf->output();
    if(isset($_POST['download']))
    $pdf->Output($filename,'D');
?>