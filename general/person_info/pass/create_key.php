<?php
include_once( "inc/auth.php" );
echo "<html>\r\n<head>\r\n<title>初始化USB用户KEY</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body class=\"bodycolor\" topmargin=\"5\" onload=\"GET_USERKEY();\">\r\n<object id=\"tdPassSC\" name=\"tdPassSC\" CLASSID=\"clsid:C7672410-309E-4318-8B34-016EE77D6B58\"\tCODEBASE=\"/inc/tdPass.cab#Version=1,00,0000\"\r\n\tBORDER=\"0\" VSPACE=\"0\" HSPACE=\"0\" ALIGN=\"TOP\" HEIGHT=\"0\" WIDTH=\"0\"></object>\r\n<object id=\"tdPass\" name=\"tdPass\" CLASSID=\"clsid:0272DA76-96FB-449E-8298-178876E0EA89\"\tCODEBASE=\"/inc/tdPass.cab#Version=1,00,0000\"\r\n\tBORDER=\"0\" VSPACE=\"0\" HSPACE=\"0\" ALIGN=\"TOP\" HEIGHT=\"0\" WIDTH=\"0\"></object>\r\n<script src=\"/inc/mytable.js\"></script>\r\n<script>\r\nfunction GetKey(va)\r\n{\r\n   var a = new VBArray(va);\r\n   return a.toArray().toString();\r\n}\r\nvar xmlHttpObj=getXMLHttpObj();\r\nvar KEY_USERINFO;\r\nvar KEY_SN;\r\nvar timeoutID;\r\n\r\nfunction READ_KEYSN()\r\n{\r\n\tvar theDevice=$(\"tdPass\");\r\n  var bOpened = OpenDevice(theDevice);\r\n  if(!bOpened)return false;\r\n  //读取设备序列号\r\n  try\r\n  {\r\n    KEY_SN=theDevice.GetStrProperty(7, 0, 0);\r\n  }\r\n  catch(ex)\r\n  {\r\n\t  theDevice.CloseDevice();\r\n\t  alert(\"USB用户KEY初始化失败!\");\r\n\t  $(\"MSG_AREA\").innerHTML=\"USB用户KEY初始化失败!\";\r\n\t  $(\"BTN_RETRY\").disabled=false;\r\n\t  return false;\r\n\t}\r\n\treturn true;\r\n}\r\nfunction GET_USERKEY()\r\n{\r\n\t$(\"MSG_AREA\").innerHTML=\"正在初始化USB用户KEY，请稍候...\";\r\n\t$(\"BTN_RETRY\").disabled=true;\r\n\tif(!READ_KEYSN())\r\n\t   return false;\r\n  var theURL=\"get_userinfo.php?KEY_SN=\"+KEY_SN;\r\n  xmlHttpObj.open(\"GET\",theURL,true);\r\n  var responseText=\"\";\r\n  xmlHttpObj.onreadystatechange=function()\r\n  {\r\n    if(xmlHttpObj.readyState==4)\r\n    {\r\n      KEY_USERINFO=xmlHttpObj.responseText;\r\n      CREAT_KEY();\r\n    }\r\n  }\r\n  xmlHttpObj.send(null);\r\n  timeoutID=window.setTimeout(function(){alert(\"获取用户信息超时，请重新初始化\");$(\"BTN_RETRY\").disabled=false;}, 30000);\r\n}\r\nfunction OpenDevice(theDevice)\r\n{\r\n   try\r\n   {\r\n      theDevice.GetLibVersion();\r\n   }\r\n   catch(ex)\r\n   {\r\n\t    alert(\"您没有下载并正确安装USB用户KEY驱动程序\");\r\n\t    $(\"MSG_AREA\").innerHTML=\"您没有下载并正确安装USB用户KEY驱动程序!\";\r\n\t    $(\"BTN_RETRY\").disabled=false;\r\n\t    return false;\r\n\t }\r\n   try\r\n   {\r\n      theDevice.OpenDevice(1, \"\");\r\n   }\r\n   catch(ex)\r\n   {\r\n\t    alert(\"您没有插人合法的USB用户KEY\");\r\n\t    $(\"MSG_AREA\").innerHTML=\"您没有插人合法的USB用户KEY!\";\r\n\t    $(\"BTN_RETRY\").disabled=false;\r\n\t    return false;\r\n\t }\r\n   return true;\r\n}\r\nfunction CREAT_KEY()\r\n{\r\n\t window.clearTimeout(timeoutID);\r\n\t var KEY_USERINFO_ARRY=KEY_USERINFO.split(\",\");\r\n\t var theDevice=$(\"tdPassSC\");\r\n   //打开设备\r\n   var bOpened = OpenDevice(theDevice);\r\n   if(!bOpened)\r\n      return false;\r\n   try\r\n   {\r\n   \t  //写用户信息\r\n   \t  var USER_INFO=KEY_USERINFO_ARRY[0];\r\n   \t  var USER_CERTINFO=KEY_USERINFO_ARRY[1];\r\n   \t  var sign=OPEN_FILE(3);\r\n   \t  if(sign==1)theDevice.DeleteFile(0,3);\r\n      theDevice.CreateFile(0,3,strlen(USER_INFO),2,0,0,7,2);\r\n      theDevice.write(0,0,0,USER_INFO,strlen(USER_INFO));\r\n      theDevice.CloseFile();\r\n      var key1;\r\n      var key2;\r\n      key1 = GetKey(VBGetKey(0,USER_CERTINFO,theDevice));\r\n\t    key2 = GetKey(VBGetKey(1,USER_CERTINFO,theDevice));\r\n\r\n     //写个人私钥\r\n     sign=OPEN_FILE(5);\r\n   \t if(sign==1)theDevice.DeleteFile(0,5);\r\n     theDevice.CreateFile(0,5,16,4,7,0,0,0);\r\n     theDevice.write(1,0,0,key1,16);//\r\n     theDevice.CloseFile();\r\n     sign=OPEN_FILE(6);\r\n   \t if(sign==1)theDevice.DeleteFile(0,6);\r\n     theDevice.CreateFile(0,6,16,4,7,0,0,0);\r\n     theDevice.write(1,0,0,key2,16);//\r\n     theDevice.CloseFile();\r\n    }\r\n   catch(ex)\r\n   {\r\n\t    theDevice.CloseDevice();\r\n\t    alert(\"USB用户KEY初始化失败!请重新初始化KEY!\\n\"+ex.description);\r\n\t    $(\"MSG_AREA\").innerHTML=\"USB用户KEY初始化失败!请重新初始化KEY!!\";\r\n\t    $(\"BTN_RETRY\").disabled=false;\r\n\t    return false;\r\n\t }\r\n\t theDevice.CloseDevice();\r\n\t alert(\"USB用户KEY初始化成功!\");\r\n\t $(\"MSG_AREA\").innerHTML=\"USB用户KEY初始化成功!\";\r\n\t $(\"BTN_RETRY\").disabled=true;\r\n\t //$(\"BTN_RETRY\").style.display=\"none\";\r\n\t return false;\r\n}\r\n\r\nfunction OPEN_FILE(fileid)\r\n{\r\n\tvar theDevice=$(\"tdPass\");\r\n  var bOpened = OpenDevice(theDevice);\r\n  if(!bOpened)return -1;\r\n  //读取设备序列号\r\n  try\r\n  {\r\n   theDevice.OpenFile (0,fileid);\r\n   theDevice.CloseFile();\r\n   return 1;\r\n  }\r\n  catch(ex)\r\n  {\r\n\t  theDevice.CloseDevice();\r\n\t  return 0;\r\n\t}\r\n}\r\n</script>\r\n<script language=\"VBScript\">\r\n'用VB函数获取到Key1和Key2\r\nfunction VBGetKey(WhichKey,CertKey,theDevice)\r\n\t\tOn Error Resume Next\r\n\t\tdim key\r\n\t\ttheDevice.Soft_MD5HMAC WhichKey,0,CertKey,key\r\n\t\tIf Err Then\r\n\t\t\tMsgBox (\"VBGetKey:No.1\\nError#\" & Hex(Err.number and &HFFFF) & \" \\nDescription:\" & Err.description)\r\n\t\t\tePass.CloseDevice\r\n\t\t\tExit function\r\n\t\tEnd If\r\n\r\n    VBGetKey = Array(key)\r\nEnd function\r\n</script>\r\n<br><br>\r\n<div align=\"center\" class=\"big1\" id=\"MSG_AREA\"></div>\r\n<br>\r\n<div align=\"center\">\r\n <input type=\"button\" value=\"重新初始化\" class=\"BigButton\" onClick=\"GET_USERKEY()\" id=\"BTN_RETRY\" disabled=\"1\">&nbsp;&nbsp;\r\n <input type=\"button\" value=\"返回\" class=\"BigButton\" onClick=\"location='index.php'\">\r\n</div>\r\n\r\n</body>\r\n</html>";
?>
<html>
<head>
<title>初始化USB用户KEY</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body class="bodycolor" topmargin="5" onload="GET_USERKEY();">
<object id="tdPassSC" name="tdPassSC" CLASSID="clsid:C7672410-309E-4318-8B34-016EE77D6B58" CODEBASE="/inc/tdPass.cab#Version=1,00,0000" BORDER="0" VSPACE="0" HSPACE="0" ALIGN="TOP" HEIGHT="0" WIDTH="0"></object>
<object id="tdPass" name="tdPass" CLASSID="clsid:0272DA76-96FB-449E-8298-178876E0EA89" CODEBASE="/inc/tdPass.cab#Version=1,00,0000" BORDER="0" VSPACE="0" HSPACE="0" ALIGN="TOP" HEIGHT="0" WIDTH="0"></object>
<script src="/inc/mytable.js"></script>
<script>
function GetKey(va){   
	var a = new VBArray(va);   
	return a.toArray().toString();
} 
var xmlHttpObj=getXMLHttpObj();
var KEY_USERINFO;
var KEY_SN;
var timeoutID;

function READ_KEYSN(){
	var theDevice=$("tdPass"); 
	var bOpened = OpenDevice(theDevice);  
	if(!bOpened)
		return false;  
	//读取设备序列号 
 	try{    
 		KEY_SN=theDevice.GetStrProperty(7, 0, 0);  
 	}  catch(ex)  {  
 		theDevice.CloseDevice();  
 		alert("USB用户KEY初始化失败!");  
 		$("MSG_AREA").innerHTML="USB用户KEY初始化失败!";  
 		$("BTN_RETRY").disabled=false;  
 		return false;
 	}
 	return true;
 }

 function GET_USERKEY(){
 	$("MSG_AREA").innerHTML="正在初始化USB用户KEY，请稍候...";
 	$("BTN_RETRY").disabled=true;
 	if(!READ_KEYSN())   
 		return false;  
 	var theURL="get_userinfo.php?KEY_SN="+KEY_SN;  
 	xmlHttpObj.open("GET",theURL,true);  
 	var responseText="";  
 	xmlHttpObj.onreadystatechange=function()  {    
 		if(xmlHttpObj.readyState==4)    {      
 			KEY_USERINFO=xmlHttpObj.responseText;      
 			CREAT_KEY();    
 		}  
 	}  
 	xmlHttpObj.send(null);  
 	timeoutID=window.setTimeout(function(){
 		alert("获取用户信息超时，请重新初始化");
 		$("BTN_RETRY").disabled=false;
 	}, 30000);
 }

 function OpenDevice(theDevice){   
 	try{      
 		theDevice.GetLibVersion();   
 	}   catch(ex)   {    
 		alert("您没有下载并正确安装USB用户KEY驱动程序");    
 		$("MSG_AREA").innerHTML="您没有下载并正确安装USB用户KEY驱动程序!";    
 		$("BTN_RETRY").disabled=false;    
 		return false; 
 	}   

 	try{      
 		theDevice.OpenDevice(1, "");   
 	}   catch(ex){    
 		alert("您没有插人合法的USB用户KEY");    
 		$("MSG_AREA").innerHTML="您没有插人合法的USB用户KEY!";    
 		$("BTN_RETRY").disabled=false;    
 		return false; 
 	}   

 	return true;
 }

 function CREAT_KEY(){ 
 	window.clearTimeout(timeoutID); 
 	var KEY_USERINFO_ARRY=KEY_USERINFO.split(","); 
 	var theDevice=$("tdPassSC");   
 	//打开设备
    var bOpened = OpenDevice(theDevice);   
    if(!bOpened)      
    	return false;   

    try   {     
    	//写用户信息   
    	var USER_INFO=KEY_USERINFO_ARRY[0];     
    	var USER_CERTINFO=KEY_USERINFO_ARRY[1];     
    	var sign=OPEN_FILE(3);     
    	if(sign==1)
    		theDevice.DeleteFile(0,3);      

    	theDevice.CreateFile(0,3,strlen(USER_INFO),2,0,0,7,2);      
    	theDevice.write(0,0,0,USER_INFO,strlen(USER_INFO));      
    	theDevice.CloseFile();      
    	var key1;      
    	var key2;      
    	key1 = GetKey(VBGetKey(0,USER_CERTINFO,theDevice));    
    	key2 = GetKey(VBGetKey(1,USER_CERTINFO,theDevice));     
    	//写个人私钥 
    	sign=OPEN_FILE(5);    
    	if(sign==1)
    		theDevice.DeleteFile(0,5);     

    	theDevice.CreateFile(0,5,16,4,7,0,0,0);     
    	theDevice.write(1,0,0,key1,16);//
    	theDevice.CloseFile();  
    	sign=OPEN_FILE(6);    
    	
    	if(sign==1)
    		theDevice.DeleteFile(0,6);     

    	theDevice.CreateFile(0,6,16,4,7,0,0,0);     
    	theDevice.write(1,0,0,key2,16);//
    	theDevice.CloseFile();    
    }   catch(ex)   {    
    	theDevice.CloseDevice();    
    	alert("USB用户KEY初始化失败!请重新初始化KEY!\n"+ex.description);    
    	$("MSG_AREA").innerHTML="USB用户KEY初始化失败!请重新初始化KEY!!";   
    	$("BTN_RETRY").disabled=false;    
    	return false; 
    } 

    theDevice.CloseDevice(); 
    alert("USB用户KEY初始化成功!"); 
    $("MSG_AREA").innerHTML="USB用户KEY初始化成功!"; 
    $("BTN_RETRY").disabled=true;
    //$("BTN_RETRY").style.display="none";
    return false;
}

function OPEN_FILE(fileid){
	var theDevice=$("tdPass");  
	var bOpened = OpenDevice(theDevice);  
	if(!bOpened)
		return -1;
    //读取设备序列号
    try  {   
    	theDevice.OpenFile (0,fileid);   
    	theDevice.CloseFile();   
    	return 1;  
    }  catch(ex)  {  
    	theDevice.CloseDevice();  
    	return 0;
    }
}
</script>
<script language="VBScript">
'用VB函数获取到Key1和Key2
function VBGetKey(WhichKey,CertKey,theDevice)
	On Error Resume Next
    dim key
    theDevice.Soft_MD5HMAC WhichKey,0,CertKey,key
    If Err Then
        MsgBox ("VBGetKey:No.1\nError#" & Hex(Err.number and &HFFFF) & " \nDescription:" & Err.description)
        ePass.CloseDevice
        Exit function
    End If
    VBGetKey = Array(key)
End function
</script>
<br>
<br>
<div align="center" class="big1" id="MSG_AREA"></div>
<br>
<div align="center"> 
<input type="button" value="重新初始化" class="BigButton" onClick="GET_USERKEY()" id="BTN_RETRY" disabled="1">
&nbsp;&nbsp; 
<input type="button" value="返回" class="BigButton" onClick="location='index.php'">
</div>
</body>
</html>