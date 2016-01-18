<?
$clip_value = <<< 'clip_block'
文件管理器缓存
1、最简单经典的var_dump()
2、配置error_log，能够解决很多疑难杂症

clip_block;


//bug
if(isset($_POST['clip']))
{
$content=htmlspecialchars($_POST['clip']);
$f=ltrim($_SERVER['PHP_SELF'], "/");
$old_content=file_get_contents($f);
file_put_contents($f,str_ireplace($clip_value, $content, $old_content) ); 
}
?>
<!-- 检查是否在线否自动保存? -->
<!DOCTYPE html>
<html>
<head>
<title>云剪贴板</title>
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<style>
body{font: 12px 微软雅黑,Arial;}
html,body{margin:0;padding:0;}

textarea
{
padding:5px;

margin: 0 5px 0 5px;
outline:none;
resize: none;
overflow: hidden;
width:95%;
font-size:20px;
border:0;
border-bottom:1px solid #0CF;
}


#bottomNav 
{
line-height:12px;
padding:5px;

text-align:center;
color:#fff;
font-size:20px;
background:green;
position:fixed;
bottom:5px;
right:5px;
}
#bottomNav:after { content:"+";}

#menu{color:#fff;margin-bottom: 10px;}
#menu span {display:block;cursor: pointer;margin: 2px 2px 25px 2px;}
</style>
</head>
<body>
<textarea id="clip"><?=$clip_value?></textarea>
<div id="bottomNav" onclick="Show_Hidden(menu)">
<!-- 绑定点击事件? id? -->
<div id='menu' hidden="hidden">
<span onclick="">撤销</span>
<span onclick="">重做</span>

<span onclick="local_Storage('local');">本地</span>
<span onclick="local_Storage('server');">异地</span>
<span onclick="local_Storage('write');">储存</span>
<span onclick='submit_data()'>提交</span>
</div>
</div>
<script>
var edit = document.querySelector("#clip");
var state = document.querySelector("#bottomNav");
    
	function resize () 
	{
        edit.style.height = 'auto';
        edit.style.height = edit.scrollHeight+'px';
    }

    function delayedResize () {window.setTimeout(resize, 0);}

	var observe;
	observe = function (element, event, handler) {element.addEventListener(event, handler, false);};
    observe(edit, 'change',  resize);
    observe(edit, 'cut',     delayedResize);
    observe(edit, 'paste',   delayedResize);
    observe(edit, 'drop',    delayedResize);
    observe(edit, 'keydown', delayedResize);
  //edit.focus();
  //edit.select();
    resize();


function Show_Hidden(trid)
{
if(trid.style.display=="block"){trid.style.display='none';}else{trid.style.display='block';}
}


edit.oninput  = function(){state.style.backgroundColor = "red";};
temp=edit.value;
//edit.value = localStorage.getItem("clip");


function local_Storage(Storage_type)
{
switch(Storage_type)
{

case "local":
edit.value = localStorage.getItem("clip");
resize();
break;

case "server":
edit.value = temp;
resize();
break;

case "write":
state.style.backgroundColor = "green" ;
localStorage.clip = edit.value;
break;
} //end switch(Storage_type)
} //end function local_Storage(Storage_type)



 function submit_data() 
 {
 var form = new FormData();
 form.append('clip', edit.value); // 文件对象

 var xhr = new XMLHttpRequest();
 xhr.open('post',  '',  true);
//xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
 xhr.onload = function () {state.style.backgroundColor = "#aaa";};
 xhr.send(form);
 }

</script>

</body>
</html>