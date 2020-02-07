document.querySelector("#logo-image").onclick = function()
{
	window.location.href = "HomePage.php";
}
function redirect(index){
	window.location.href = "userPage.php?user_id=" + index;  
}
function ajax(endpoint, printFunction)
{
	let xhr = new XMLHttpRequest();
	xhr.open("GET", endpoint, true);
	xhr.send();
	xhr.onreadystatechange = function(){
		if (this.readyState == this.DONE)
		{
			if (xhr.status == 200)
			{
				//console.log(JSON.parse(xhr.responseText));
                let Results = JSON.parse(xhr.responseText);
                printFunction(Results);
			}
			else{
				console.log("AJAX error");
				console.log(xhr.status);
			}
		}
	}
}