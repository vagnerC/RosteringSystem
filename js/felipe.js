console.log("Connected to felipe.js");
	var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
	var month ={
		'January':[], //31 days
		'February':[], //28 days
		'March':[], //31 days
		'April':[],
		'May':[],
		'June':[],
		'July':[],
		'August':[],
		'September':[],
		'October':[],
		'November':[],
		'December':[]
	}
	/** Each week has 7 days**/
	var weeks ={
		'week1':[],
		'week2':[],
		'week3':[],
		'week4':[],
		'week5':[],
	}
	var daysOftheWeek ={
		'Sunday':[],
		'Monday':[],
		'Tuesday':[],
		'Wednesday':[],
		'Thursday':[],
		'Friday':[],
		'Saturday':[]
		
	}
	// daysOftheWeek.Monday.push(monday)''

	var monday = {
		'Open': [],
		'Close': []
	}
	var tuesday = {
		'Open': [],
		'Close': []
	}
	var wednesday = {
		'Open': [],
		'Close': []
	}
	var thursday = {
		'Open': [],
		'Close': []
	}
	var friday = {
		'Open': [],
		'Close': []
	}
	var saturday = {
		'Open': [],
		'Close': []
	}

	//sunday.Open.push("Open")
	var sunday = {
		'Open': [],
		'Close': [],
 	}

 	/** get the open/close time of each day of the daysOftheWeek
 	*	and store it in it's variable then store the var in the daysOftheWeek array
 	**/
 	function replace(x,y,z){
 		x = x.replace("y","z");
 		return x
 	}
 	function saveOpenClose(){
 		/**Sunday**/
 		var sundayOpen, sundayClose;
 		sundayOpen = document.getElementById("sundayOpen").value;
 		sundayOpen = sundayOpen.replace(":","");
 		
 		sundayClose = document.getElementById("sundayClose").value;
 		sundayClose = sundayClose.replace(":","");

 		window.sunday.Open = sundayOpen;
 		window.sunday.Close = sundayClose;
 		daysOftheWeek.Sunday.push(sunday);

 		/**Monday**/
 		window.monday.Open = document.getElementById("mondayOpen").value;
 		window.monday.Close = document.getElementById("mondayClose").value;
 		daysOftheWeek.Monday.push(monday);

 		/**Tuesday**/
 		window.tuesday.Open = document.getElementById("tuesdayOpen").value;
 		window.tuesday.Close = document.getElementById("tuesdayClose").value;
 		daysOftheWeek.Tuesday.push(tuesday);

 		/**Wednesday**/
 		window.wednesday.Open = document.getElementById("wednesdayOpen").value;
 		window.wednesday.Close = document.getElementById("wednesdayClose").value;
 		daysOftheWeek.Wednesday.push(wednesday);

 		/**Thursday**/
 		window.thursday.Open = document.getElementById("thursdayOpen").value;
 		window.thursday.Close = document.getElementById("thursdayClose").value;
 		daysOftheWeek.Thursday.push(thursday);

 		/**Friday**/
 		window.friday.Open = document.getElementById("fridayOpen").value;
 		window.friday.Close = document.getElementById("fridayClose").value;
 		daysOftheWeek.Friday.push(friday);

 		/**Saturday**/
 		window.saturday.Open = document.getElementById("saturdayOpen").value;
 		window.saturday.Close = document.getElementById("saturdayClose").value;
 		daysOftheWeek.Saturday.push(saturday);

 		console.log("Open and closing time is save into the daysOfweekArray")

 		generateStaffHours();
 		
 	}
 	//return the openTime
 	function getOpenTime(x){
 		return x.Open;
 	}
 	function getCloseTime(x){
 		return x.Close;
 	}

 	function generateStaffHours(daysOftheWeek){
 		//this is a row
 		var columns, row, colInRow;
 		var start = document.getElementById("staffHours"); 

 		for(var i=0; i< days.length;i++){
 			columns = document.createElement("div");
	 		columns.className = "col";

 			columns.innerHTML += "<p>"+days[i]+"</p>";
 			start.appendChild(columns);

 			//j = opening time      j < close time
 			var x = sunday.Open;
 			for(var j=0; j<8; j++){
 				row = document.createElement("div");
		 		row.className = "row";

		 		colInRow = document.createElement("div");
		 		colInRow.className = "col";

		 		var next = j+1;
 				colInRow.innerHTML = j+" to "+next;
 				row.appendChild(colInRow);
 			 	columns.appendChild(row);
 			}

 		}
 		//create 7 coluns in this for each day of the week



 	}
// 	// example monday.open.push(value);
// ng the classes from framework 7 into it
//     card = document.createElement("div");
//     card.className = "card";

//     cardContent = document.createElement("div");
//     cardContent.className = "card-content";

//     cardContentInner = document.createElement("div");
//     cardContentInner.className = "card-content-inner";
//     cardContentInner.innerHTML = arrayOfData[i];
    

//     //so the var start is the root node                   start           = Grandad
//     start.appendChild(card);                        //    card            = Parent
//     //the the card is the child of the Root               cardContent     = Child
//     card.appendChild(cardContent);                  //    cardContentInner= Great Gran Child...
//     //the card content is the child of the card
//     cardContent.appendChild(cardContentInner);
//     //the card 



