<?php

    // Doesn't work on Localhost - Unable to Test

    require "./Includes/db.php";
    require "./Includes/functions.php";

    if(isset($_GET['id'])) {
        
        // This section doesn't work in Localhost due to email limitations. For the sake of development - have the reset password take straight to the reset page from within admin.
        // $accountToEmail = returnCleanUserData($_GET['id']);
        // $sqlstatement = "SELECT * FROM users WHERE UUID = '{$accountToEmail}'";
        // global $connection;
        // $emailQuery = mysqli_query($connection, $sqlstatement);

        // if(!$emailQuery) {
        //     die("Query failed ". mysqli_error($connection));        
        // } else {
        //     $row = mysqli_fetch_assoc($emailQuery);

        //     $to = "{$row['email_address']}";
        //     $subject = "You're nearly ready to use your account";
        //     $from = 'suffolkswimmers@yahoonext.com';
            
        //     // To send HTML mail, the Content-type header must be set
        //     $headers  = 'MIME-Version: 1.0' . "\r\n";
        //     $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            
        //     // Create email headers
        //     $headers .= 'From: '.$from."\r\n".
        //         'Reply-To: '.$from."\r\n" .
        //         'X-Mailer: PHP/' . phpversion();
            
        //     // Compose a simple HTML email message
        //     $message = '<html><body>';
        //     $message .= '<h1 style="color:#255c5f;">Please unlock your account</h1>';
        //     $message .= '<p style="color:#20262b;font-size:16px;">In order to access your account, you need to set a new password for it. Click the following link to set your password:</p>';
        //     $message .= "<p style='color:#20262b;font-size:16px;'><a href='./resetpassword.php?id={$row['UUID']}'>Click Here</a></p>";
        //     $message .= '<p style="color:#20262b;font-size:16px;">Thanks very much!!.</p>';
        //     $message .= '</body></html>';
            

        //     // Sending email
        //     if(mail($to, $subject, $message, $headers)){
        //         header("Location: viewusers.php");
        //     } else{
        //         echo 'Unable to send email. Please try again.';
        //     }
        // }


        $idtoReset = returnCleanUserData($_GET['id']);

        header("Location: passwordReset.php?id={$idtoReset}");


    }


?>