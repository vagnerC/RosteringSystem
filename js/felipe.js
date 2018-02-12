console.log("Connected to felipe.js");

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
		'Monday':[],
		'Tuesday':[],
		'Wednesday':[],
		'Thursday':[],
		'Friday':[],
		'Saturday':[],
		'Sunday':[]
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
 	function saveOpenClose(){
 		/**Sunday**/
 		window.sunday.Open = document.getElementById("sundayOpen").value;
 		window.sunday.Close = document.getElementById("sundayClose").value;
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

 		
 	}

 	function generateStaffHours(daysOftheWeek){
 		daysOftheWeek

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



