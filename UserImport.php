<?php

    // Global vars. Update to suit your needs
    $CSVFile ='SampleImport.csv';
    $LoginPassword = 'Change123Me!';

    use Magento\Framework\App\Bootstrap;
    require 'app/bootstrap.php';
    $bootstrap = Bootstrap::create(BP, $_SERVER);
    $objectManager = $bootstrap->getObjectManager();
    $UserFactory = $objectManager->get('\Magento\User\Model\UserFactory');

    $csvFile = fopen($CSVFile, 'r');

    while (($line = fgetcsv($csvFile)) !== FALSE) {

        // Array structure from csv
            // 0 = Username
            // 1 = Firstname
            // 2 = Lastname
            // 3 = Email
            // 4 = Role

            $Username = (string) $line[0];
            $FirstName = (string) $line[1];
            $LastName = (string) $line[2];
            $Email = (string) $line[3];
            $Role = (int) $line[4];

        try{
            $adminInfo = [
            'username'         => $Username,
            'firstname'        => $FirstName,
            'lastname'         => $LastName,
            'email'            => $Email,
            'password'         => $LoginPassword,       
            'interface_locale' => 'en_US',
            'is_active'        => 1
        ];

        $userModel = $UserFactory->create();
        $userModel->setData($adminInfo);
        $userModel->setRoleId($Role);
        $userModel->save(); 
    
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            echo "\n";
        }    
        
        echo "$Username was sucessfully created! \n";

    }

    fclose($csvFile);

?>