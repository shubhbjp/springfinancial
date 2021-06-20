function changeClass(c=''){
	currEleClassName = c
}

function setClassVisibility(v='visible'){
	try{document.getElementsByClassName(currEleClassName)[0].style.visibility=v} catch(err){}
}

function showCurrClass(className){
	changeClass(className)
	setClassVisibility("visible")
}

function hideCurrClass(className){
	changeClass(className)
	setClassVisibility("hidden")
}

function getClassValue(c=''){
	try{return document.getElementsByClassName(c)[0].value}catch(err){return ''}
}

function setClassValue(c='', v=''){
	changeClass(c)
	try{return document.getElementsByClassName(c)[0].value = v}catch(err){return ''}
}

function reloadFormData(){
	setClassValue('new-user-ip-name', '')
	setClassValue('new-user-ip-age', 0)
	setClassValue('new-user-ip-address', '')
}

function cancel(){
	hideCurrClass("new-user-data")
	showCurrClass("new-user")
	reloadFormData()
}
function showContainer(){
	changeClass('container')
	setClassVisibility()
}
function list(){
	participant_container_id = document.getElementById("participant-container")
	participant_container_id.innerHTML = ''

	for (var i=0;i<participants.length;i++) {
		var participantId = document.createElement('div')
		participantId.classList.add("participant")
		participantId.id=i
		html = ''
		html += '<div class="atn-btn cross"onclick=del(this);><b>X</b></div>'
		html += '<div class="name" onclick=showData(this);><b>'+participants[i]['name']+'</b></div>'
		if(participants[i]['points'] <= 1000) {
			html += '<div class="atn-btn" onclick=pls(this);><b>+</b></div>'
		}
		if(participants[i]['points'] > 0) {
			html += '<div class="atn-btn" onclick=min(this);><b>-</b></div>'
		}			
		html += '<div class="name">'+participants[i]['points']+' points</div>'
		participantId.innerHTML = html
		participant_container_id.append(participantId)
	}
}

function getNewList(){
	var xhttp = new XMLHttpRequest()
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			resp = JSON.parse(this.responseText)
			if(resp.status="SUCCESS") {
				participants = resp.data
				list()
			} else {
				alert(resp.message);
			}
		}
	}
	xhttp.open("GET", "index.php?control_type=game&api_name=getUser", true)
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xhttp.send()
}
function save(){
	var xhttp = new XMLHttpRequest()
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			resp = JSON.parse(this.responseText)
			if(resp.status=="SUCCESS") {
				participants = resp.data
				list()
				cancel()
			} else {
				alert(resp.message);
			}
		}
	}
	xhttp.open("POST", "index.php", true)
	data = "name="+encodeURIComponent(name)+"&age="+encodeURIComponent(age)+"&address="+encodeURIComponent(address)+"&control_type=game"+"&api_name=addNewUser"
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xhttp.send(data)
}
function save_validation(){
	name = getClassValue('new-user-ip-name')
	age = getClassValue('new-user-ip-age')
	address = getClassValue('new-user-ip-address')
	if (name == "") {
		alert("New User Name Cannot be empty")
	} else if ( (age == "") || (Number(age) <=0) ){
		alert("New User Age Cannot be empty or <= 0")
	} else if (address == "") {
		alert("New User Address Cannot be empty")
	} else {
		save(name,age,address)
	}
}

function load(){
	var currEleClassName
	cancel()
	showContainer()
	var participants = []	
	getNewList()
	document.getElementsByClassName("new-user")[0].onclick=function(){
		hideCurrClass("new-user")
		showCurrClass("new-user-data")
	}
	document.getElementsByClassName("cancel")[0].onclick=function(){
		cancel()
	}
	document.getElementsByClassName("save")[0].onclick=function(){
		save_validation()
	}
	changeClass('show-data')
	setClassVisibility('hidden')
}

function pls(cId){
	changeClass('show-data')
	setClassVisibility('hidden')
	currId = cId.parentElement.id
	var xhttp = new XMLHttpRequest()
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			resp = JSON.parse(this.responseText)
			if(resp.status=="SUCCESS") {
				participants = resp.data
				list()
			} else {
				alert(resp.message);
			}
		}
	}
	xhttp.open("POST", "index.php", true)
	data = "id="+encodeURIComponent(currId)+"&control_type=game"+"&api_name=plusUserPoint"
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xhttp.send(data)
}

function min(cId){
	changeClass('show-data')
	setClassVisibility('hidden')
	currId = cId.parentElement.id
	var xhttp = new XMLHttpRequest()
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			resp = JSON.parse(this.responseText)
			if(resp.status=="SUCCESS") {
				participants = resp.data
				list()
			} else {
				alert(resp.message);
			}
		}
	}
	xhttp.open("POST", "index.php", true)
	data = "id="+encodeURIComponent(currId)+"&control_type=game"+"&api_name=minUserPoint"
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xhttp.send(data)
}

function del(cId){
	changeClass('show-data')
	setClassVisibility('hidden')
	currId = cId.parentElement.id
	var xhttp = new XMLHttpRequest()
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			resp = JSON.parse(this.responseText)
			if(resp.status=="SUCCESS") {
				participants = resp.data
				list()
			} else {
				alert(resp.message);
			}
		}
	}
	xhttp.open("POST", "index.php", true)
	data = "id="+encodeURIComponent(currId)+"&control_type=game"+"&api_name=delUserPoint"
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xhttp.send(data)
}

function showData(cId){
	currId = Number(cId.parentElement.id)
	changeClass('show-data')
	setClassVisibility()
	try{	document.getElementsByClassName('show-data')[0].innerHTML = '<span>Name: '+participants[currId]['name']+' Age: '+participants[currId]['age']+' Address: '+participants[currId]['address']+' Points: '+participants[currId]['points']+'</span>'} catch(err){}

}