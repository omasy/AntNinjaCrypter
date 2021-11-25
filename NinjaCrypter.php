<?php

namespace App;

class NinjaCrypter
{
	public function accessCreator($username=null, $password=null){
		// NOW LETS PROCESS USERNAME AND PASSWORD TO CREATE AN ACCESS STRING
		// Processing Email
		if($username!=null){
			// Email is sent
			// Lets break email
			$breakbyAT=explode("@", $username);
			// Now lets get each parts
			if(is_array($breakbyAT)){
				// NOW WE KNOW THAT WE HAVE GOTTEN OUR FIRST ARRAY FROM EMAIL WHICH IS @
				$partA=$breakbyAT[0];
				$partB=$breakbyAT[1];
				// NOW LETS BREAK PART B BY DOT(.)
				$breakbyDot=explode(".", $partB);
				// NOW LETS CHECK IF DOT IS MORE THAN ONE
				if(is_array($breakbyDot) && count($breakbyDot)<3){
					// HERE WE HAVE NORMAL EMAIL ADDRESS
					$bpartA=$breakbyDot[0];
					$bpartB=$breakbyDot[1];
					// NOW LETS CREATE ACCESS EMAIL STRING
					$chars=md5(uniqid(rand(10000000000, 99999999999), true));
					$text=substr($chars, 0, 10);
					// Random Numbers
					$num=substr(rand(10000000000, 99999999999), 0, 8);
					// SETTING THE MAIL STRING
					$emailString=$partA.$text."oma".$bpartA."acc".$num.$bpartB.substr(time(), 0, 5);	
				}
				else{
					// HERE WE HAVE COSTUM EMAIL ADDRESS
					if(count($breakbyDot)>2 && count($breakbyDot)<4){
						// HERE WE ARE CHECKING THAT EMAIL IS NOT ABOVE CUSTOM EMAIL
						$bpartA=$breakbyDot[0];
						$bpartB=$breakbyDot[1];
						$bpartC=$breakbyDot[2];
						// NOW WE HAVE THRE PART FROM DOT SIDE
						// SO WE CREATE UNIQUE STRING FOR ACCESS
						$chars=md5(uniqid(rand(10000000000, 99999999999), true));
						$text=substr($chars, 0, 10);
						// Random Numbers
						$num=substr(rand(10000000000, 99999999999), 0, 8);
						// SETTING THE MAIL STRING
						$emailString=$partA.$text."oma".$bpartA."acc".$num.$bpartB.date("Y").$bpartC.substr(time(), 0, 5);
					}
					else{
						// WE HAVE TO RETURN FALSE
						return false;	
					} // END OF CUSTOM EMAIL CHECK
				} // END OF EMAIL CHECK
			} //END OF AT ARRAY BREAK

			// END OF USERNAME VALUE CHECK
		}
		else{
			return false;	
		}


		// PROCESSING PASSWORD TO STRING
		if($password!=null){
			// NOW LETS GET VALUES FROM PASSWORD
			$first=substr($password, 0, 1);
			$second=substr($password, 0, 2);
			$third=substr($password, (strlen($password)-1));
			$fourth=substr($password, (strlen($password)-2));
			// GETTING THE FIFTH VALUE WE DO
			$countPass=strlen($password);
			$fifth=$countPass/2;
			
			// NOW LETS MAKE STRING
			$passwordString=$first.substr($fifth, 0, 1).$fourth.$second.$third.(0).$password;
			// END OF PASSWORD VALUE CHECK	
		}


		// NOW LETS CREATE WHOLE STRING
		if(isset($emailString) && isset($passwordString)){
			// NOW LETS JOIN AND RETURN STRING
			$preparedString=$emailString."-".$passwordString;
			// NOW LETS RETURN
			return $preparedString;	
		}
	}





	/******************** CONSTRUCTING THE ACCESS READER FUNCTION *********************/
	public function accessValidator($accessString){
		// NOW LETS VALIDATE THE ACCESS STRING
		if(strpos($accessString, "-")!==false){
			// WE PROCEED INTO THE NEXT CHECK
			// Now lets break string to get email part and password part
			$breakString=explode("-", $accessString);
			// NOW LETS GET PARTS
			$emailPart=$breakString[0];
			$passPart=$breakString[1];
			// NOW LETS VALIDATE THE EMAIL PART FIRST
			// Lets break email into two parts
			if(strpos($emailPart, "oma")!==false && strpos($emailPart, "acc")!==false){
				// WE VALIDATE PASSWORD
				// NOW LETS VALIDATE THE PASSWORD STRING
				$joinIndex=strpos($passPart, "0");
				// NOW LETS GET OUR VALID DIGITS
				$validDigits=substr($passPart, 0, $joinIndex);
				// NOW LETS CHECK VALIDATOR CODE
				$passDigits=substr($passPart, ($joinIndex+1));
				// NOW LETS GET CODES TO CHECK
				$first=substr($passDigits, 0, 1);
				$second=substr($passDigits, 0, 2);
				$third=substr($passDigits, (strlen($passDigits)-1));
				$fourth=substr($passDigits, (strlen($passDigits)-2));
				// Getting fifth value
				$countPass=strlen($passDigits);
				$fifth=substr(($countPass/2), 0, 1);
				
				// NOW LETS CHECK PASSWORD VALIDITY
				if(substr($validDigits, 0, 1)==$first && substr($validDigits, 1, 1)==$fifth && substr($validDigits, 2, 2)==$fourth){
					// WE HAVE PASSED THE FIRST LEVEL VALIDATION
					if(substr($validDigits, 4, 2)==$second && substr($validDigits, 6, 1)==$third){
						// NOW WE HAVE PASS THE ACCESS VALIDATION
						return true;	
					}
					else{
						// LETS RETURN FALSE
						return false;	
					}
				}
				else{
					// LETS RETURN FALSE
					return false;	
				}
			}
			else{
				// WE RETURN FALSE
				return false;	
			}
		}
		else{
			// WE RETURN FALSE. UN-IDENTIFIED ACCESS
			return false;	
		}
		
		// END OF FUNCTION
	}







	/***************** CONSTRUCTING THE ACCESS PASSER FUNCTION *****************/
	public function accessParser($accessString){
		// LETS FIRST CHECK ACCESS STRING AND SEE IF ITS VALIDATING
		$validAccess=$this->accessValidator($accessString);
		// NOW LETS CHECK THE RETURN TO KNOW IF WE SHOULD PROCEED OR NOT
		if($validAccess==true){
			// WE PORCEED TO PARSING THE ACCESS STRING
			// FIRST WE CHECK IF OUR PASS EMAIL LINKER IS IN PLACE
			if(strpos($accessString, "-")!==false){
				// NOW LETS FIRST GET OUR EMAIL PART
				$breakParts=explode("-", $accessString);
				// LETS CHECK EMAIL TYPE TO KNOW HOW WE CAN PROCESS
				$date=date("Y");
				if(strpos($breakParts[0], $date)!==false){
					// NOW WE KNOW WE ARE HANDLING CUSTOM EMAIL
					// Lets break my "oma"
					$breakbyOMA=explode("oma", $breakParts[0]);
					// NOW LETS GET PARTS OF OMA  BREAK
					$omaLeft=$breakbyOMA[0];
					$omaRight=$breakbyOMA[1];
					// NOW LETS GET OUR FIRST STRING
					$emailName=substr($omaLeft, 0, (strlen($omaLeft)-10));
					// NOW LETS BREAK BY ACC TO GET OTHE DATAS
					$breakbyACC=explode("acc", $omaRight);
					// NOW LETS GET EMAIL HOST
					$emailHost=$breakbyACC[0];
					// LETS BREAK FURTHER NY DATE
					$breakbyDATE=explode(date("Y"), $breakbyACC[1]);
					// NOW LETS GET OUR FIRST ACCESS
					$emailAccess1=substr($breakbyDATE[0], 9);
					$emailAccess2=substr($breakbyDATE[1], 0, (strlen($breakbyDATE[1])-5));
					// NOW LETS FORM A VALID EMAIL ADDRESS FROM RETRIEVED DATA
					$email=$emailName."@".$emailHost.".".$emailAccess1.".".$emailAccess2;	
				}
				else{
					// Lets break my "oma"
					$breakbyOMA=explode("oma", $breakParts[0]);
					// NOW LETS GET PARTS OF OMA  BREAK
					$omaLeft=$breakbyOMA[0];
					$omaRight=$breakbyOMA[1];
					// NOW LETS GET OUR FIRST STRING
					$emailName=substr($omaLeft, 0, (strlen($omaLeft)-10));
					// NOW LETS BREAK BY ACC TO GET OTHE DATAS
					$breakbyACC=explode("acc", $omaRight);
					// NOW LETS GET EMAIL HOST
					$emailHost=$breakbyACC[0];
					// NOW LETS PROCESS MORE TO GET OUR EMAIL ACCESS POINT
					$approachAccess=substr($breakbyACC[1], 8);
					// LETS GET ACCESS
					$emailAccess=substr($approachAccess, 0, (strlen($approachAccess)-5));
					
					// MAKE A VALID EMAIL OUT OF THE DATAS RETRIEVED
					$email=$emailName."@".$emailHost.".".$emailAccess;
				} // END OF EMAIL TYPE CHECK
				
				
				// NOW LETS RETRIEVE PASSWORD TO MATCH EMAIL FOR USER LOGIN
				$password=substr($breakParts[1], 8);
				
				// NOW LETS CONVERT TO ARRAY AND RETURN
				$userpass=array($email, $password);
				// NOW LETS RETURN ARRAY OF USERNAME AND PASSWORD
				return $userpass;
			}
			else{
				// WE RETURN FALSE
				return false;
			} // END OF OUR PASS EMAIL LINKER CHECK
		}
		else{
			// WE RETURN FALSE
			return false;	
		}
		// End of function
	}
	
	// END OF CLASS	
}