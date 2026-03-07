<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume - John Doe</title>
    <link rel="stylesheet" href="styles.css">
    <style type="text/css">
      body {
          font-family: Arial, sans-serif;
          background-color: #f4f4f4;
          margin: 0;
          padding: 20px;
          display: flex;
          justify-content: center;
          align-items: flex-start;
      }

      .resume-container {
          background-color: #fff;
          padding: 20px;
          max-width: 800px;
          width: 100%;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          border-radius: 8px;
      }

      .header {
          display: flex;
          align-items: center;
          margin-bottom: 20px;
      }

      .profile-photo {
          width: 100px;
          height: 100px;
          border-radius: 50%;
          margin-right: 20px;
          border: 2px solid #ddd;
      }

      .header-info h1 {
          margin: 0;
      }

      .header-info span {
          font-size: 12px;
      }

      .section {
          margin-bottom: 20px;
      }

      .section h2 {
          border-bottom: 2px solid #f4f4f4;
          padding-bottom: 10px;
          margin-bottom: 10px;
      }

     

      .skills-list {
          list-style-type: none;
          padding: 0;
          display: flex;
          flex-wrap: wrap;
      }

      .skills-list li {
          background: #e4e4e4;
          margin: 5px;
          padding: 10px;
          border-radius: 4px;
          flex: 1 0 30%;
          text-align: center;
      }

    </style>
</head>
<body>
    <div class="resume-container">
        <header class="header">
          <table class="table">
            <tr>
              <td width="70%">
                <div class="header-info">
                  <h1><?=$records[0]['employee_name'];?></h1><br>
                  <table class="table" style="font-size: 12px;">
                    <tr>
                      <td width="30%"><strong>Designation</strong></td>
                      <td width="70%">: <?=$records[0]['designation_name'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Email</strong></td>
                      <td width="70%">: <?=$records[0]['employee_email'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Phone</strong></td>
                      <td width="70%">: <?=$records[0]['emp_mobile'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Alternate Phone</strong></td>
                      <td width="70%">: <?=$records[0]['emp_amobile'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Nick name</strong></td>
                      <td width="70%">: <?=$records[0]['emp_nickname'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Gender</strong></td>
                      <td width="70%">: <?=$records[0]['emp_gender'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>DOB</strong></td>
                      <td width="70%">: <?=$records[0]['emp_dob']?date('d-m-Y',strtotime($records[0]['emp_dob'])):'';?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Father's/Hus.'s Name</strong></td>
                      <td width="70%">: <?=$records[0]['emp_fathername']?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Mother's Name</strong></td>
                      <td width="70%">: <?=$records[0]['emp_mothername'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Parents/Guardian Phone No.</strong></td>
                      <td width="70%">: <?=$records[0]['emp_pgmobile'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Age</strong></td>
                      <td width="70%">: <?=$records[0]['emp_age'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Blood Group</strong></td>
                      <td width="70%">: <?=$records[0]['emp_bloodgrp'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Date of Joining</strong></td>
                      <td width="70%">: <?=$records[0]['emp_doj']?date('d-m-Y',strtotime($records[0]['emp_doj'])):'';?></td>
                    </tr>
                  </table>
                  
                </div>
              </td>
              <td width="30%" style="text-align:right;"><img src="<?=base_url("uploads/employee/".$records[0]['emp_photo']);?>" alt="John Doe" class="profile-photo"></td>
            </tr>
          </table>
            
            
        </header>

        <section class="section">
          <h2>Address</h2>
            <table class="table" style="font-size: 12px;">
              <tr>
                <td width="50%">
                  <span><strong style="text-decoration: underline;">Current Address</strong></span><br>
                  <table class="table" style="font-size: 11px;">
                    <tr>
                      <td width="30%"><strong>Plot No</strong></td>
                      <td width="70%">: <?=$records[0]['emp_plotno'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>At</strong></td>
                      <td width="70%">: <?=$records[0]['emp_at'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Po</strong></td>
                      <td width="70%">: <?=$records[0]['emp_po'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Tahsil</strong></td>
                      <td width="70%">: <?=$records[0]['emp_tahsil'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>State</strong></td>
                      <td width="70%">: <?=$state?$state[0]['state_title']:'';?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>District</strong></td>
                      <td width="70%">: <?=$district?$district[0]['district_title']:'';?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Pin Code</strong></td>
                      <td width="70%">: <?=$records[0]['emp_curpin'] > 0?$records[0]['emp_curpin']:''?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Landmark</strong></td>
                      <td width="70%">: <?=$records[0]['emp_landmark'];?></td>
                    </tr>
                    
                  </table>
                </td>
                <td width="50%">
                  <span><strong style="text-decoration: underline;">Permanent Address</strong></span><br>
                  <table class="table" style="font-size: 11px;">
                    <tr>
                      <td width="30%"><strong>Plot No</strong></td>
                      <td width="70%">: <?=$records[0]['emp_plotnop'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>At</strong></td>
                      <td width="70%">: <?=$records[0]['emp_atp'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Po</strong></td>
                      <td width="70%">: <?=$records[0]['emp_pop'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Tahsil</strong></td>
                      <td width="70%">: <?=$records[0]['emp_tahsilp'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>State</strong></td>
                      <td width="70%">: <?=$statep?$statep[0]['state_title']:'';?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>District</strong></td>
                      <td width="70%">: <?=$districtp?$districtp[0]['district_title']:'';?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Pin Code</strong></td>
                      <td width="70%">: <?=$records[0]['emp_curpinp'] > 0?$records[0]['emp_curpinp']:''?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Landmark</strong></td>
                      <td width="70%">: <?=$records[0]['emp_landmarkp'];?></td>
                    </tr>
                    
                  </table>
                </td>
              </tr>
            </table>
            
        </section>

        <section class="section">
            <h2>Bank & Kyc </h2>
           <table class="table" style="font-size: 12px;">
              <tr>
                <td width="50%">
                  <table class="table" style="font-size: 11px;">
                    <tr>
                      <td width="30%"><strong>Bank Name</strong></td>
                      <td width="70%">: <?=$records[0]['st_bankname'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Account Number</strong></td>
                      <td width="70%">: <?=$records[0]['st_acno'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>A/c Holder Name</strong></td>
                      <td width="70%">: <?=$records[0]['st_acholdername'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>IFSC Code</strong></td>
                      <td width="70%">: <?=$records[0]['st_ifsc'];?></td>
                    </tr>
                  </table>
                </td>
                <td width="50%">
                  <table class="table" style="font-size: 11px;">
                    <tr>
                      <td width="30%"><strong>Pan Number</strong></td>
                      <td width="70%">: <?=$records[0]['kyc_panno'];?></td>
                    </tr>
                    <tr>
                      <td width="30%"><strong>Aadhaar No</strong></td>
                      <td width="70%">: <?=$records[0]['kyc_adharno'];?></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
                
        </section>
       
        <section class="section">
            <h2 style="margin-bottom: 0!important;padding-bottom: 0!important;">Experience</h2>
            <div class="experience-item">
                <span><strong><?=$records[0]['exp_year'];?> Yr</strong> </span>
            </div>
            
        </section>

        <?php if ($ecademicrec) { ?>
        <section class="section">
            <h2>Education</h2>
            <table class="table" style="font-size: 11px;">
                   
            <?php for ($i=0; $i <count($ecademicrec) ; $i++) { ?>
              <tr>
                <td>
                  <span> <?=$ecademicrec[$i]['examination_passed'];?> - <?=$ecademicrec[$i]['stream'];?> <span><span style="font-size:12px;"><?=$ecademicrec[$i]['name_univercity'];?></span> (<?=$ecademicrec[$i]['year_passing'];?>)</span></span>
                </td>
              </tr>
            <?php } ?>
          </table>
        </section>
        <?php } ?>

        <?php if ($trainingrec) { ?>
        <section class="section">
            <h2>Training</h2>
             <table class="table" style="font-size: 11px;">
                <?php for ($i=0; $i <count($trainingrec) ; $i++) { ?>
                <tr>
                  <td>
                    <span> <?=$trainingrec[$i]['trainingtype'];?> - <?=$trainingrec[$i]['topicname'];?> <span><span style="font-size:12px;"><?=$trainingrec[$i]['institutename'];?></span> (<?=$trainingrec[$i]['datefrom']?date('d M Y',strtotime($trainingrec[$i]['datefrom'])):'';?> - <?=$trainingrec[$i]['dateto']?date('d M Y',strtotime($trainingrec[$i]['dateto'])):'';?>)</span></span>
                    </td>
                </tr>
                <?php } ?>
                  
              </table>
        </section>
        <?php } ?>


    </div>
</body>
</html>
