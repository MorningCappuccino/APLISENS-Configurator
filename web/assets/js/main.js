
// (function(){
	"use strict";

/*
* #On load init
* #Main API
*   -Rollback Dropdown
* #Helpders API
* #Temprary
*/



/*
		On load init
*/
	$('.dropdown').tooltip({
		container: 'body'
	});
// $('#eq_mode').on('load', function(event, value, caption) {

function reviveFirstDropdown(){
	var whoAmI = $('#eq_mode > button').attr('id');

		$.ajax({
			url: 'http://rainbow2/ajax/',
			method: 'post',
			data: {
				action_name: 'getAllEqMode'
		},
		success: function(data){
			$('.jumbotron').html(data);
			$('#eq_mode ul').html(data);
			reviveItself();
		}
	});

}
// });

reviveFirstDropdown();


/*
	main API
 */

var Core = {
	ajaxUrl: 'http://rainbow2/ajax/',
	eqModeID: null,
	eqModeTitle: '',
	accuracyID: null,
	specialVersionID: null,
	measurementRangeID: null,
	bodyTypeID: null,
	bodyTypeTitle: '',
	processConnectionID: null,
	//modal field
	pulsePipeLength: null,
	cableLength: null,
	//end modal field
}

function reviveNextParam(nextParam){

	switch(nextParam){
		case 2: reviveAccuracy(); break;
		case 3: reviveSpecialVersion(); break;
		case 4: reviveMeasurementRange(); break;
		case 5: reviveBodyType(); break;
		case 6: reviveProcessConnection(); break;
	}
	// secondDropDown();
}

// function revive(dd_ul, ){
// 	dd_ul.on('click', 'li', function(){

// 	}
// }

function reviveItself(){

	$('#eq_mode ul').on('click', 'li', function(value, caption){
		var eqModeID = this.value,
				eqModeTitle = this.innerText;
		Core.eqModeID = eqModeID;
		Core.eqModeTitle = eqModeTitle;

		var eqModeTitle = this.innerText;
		var dropdownTitle = $('#eq_mode button').text(eqModeTitle);
		var accuracyBtn = $('#accuracy button'),
				nextParam = +accuracyBtn.attr('id');

		//clear accuracy label
		// accuracyBtn.text('');



		$.ajax({
			url: Core.ajaxUrl,
			method: 'post',
			data: {
				action_name: 'getAccuracyClassesByEqModeID',
				eq_mode_id: eqModeID
			},
		success: function(data){
			if (data != "no data") {
				blink(2, '#ABFCB2');
				accuracyBtn.removeAttr('disabled');
				$('.jumbotron').html(data);
				$('#accuracy ul').html(data);
				reviveNextParam(nextParam);
			} else {
				blink(2, '#FFA0A0')
			}
		}
	});

});

}

function reviveAccuracy(){
	$('#accuracy ul li').on('click', function(){

		//need eqModeID
		//may be get from global object?
		//or search from 'eq_mode' ul>li-selected;

		var thisBtn = $('#special_version button');

		var accuracyID = this.value, //now it's not needed
				accuracyTitle = this.innerText,
				nextParam = +thisBtn.attr('id');
		Core.accuracyID = accuracyID;

		//set Title to Dropdown
		$('#accuracy button').text(accuracyTitle);

		$.ajax({
			url: Core.ajaxUrl,
			method: 'post',
			data: {
				action_name: 'getSpecialVersionsByEqModeID',
				eq_mode_id: Core.eqModeID
			},
			success: function(data){
				if (data != 'no data'){
					blink(nextParam, '#ABFCB2')
					thisBtn.removeAttr('disabled');
					$('#special_version ul').html(data); //append
					$('.jumbotrone').html(data);
					reviveNextParam(nextParam);
				} else {
					blink(nextParam, '#FFA0A0');
				}
			}
		});


	});
}


function reviveSpecialVersion(){
	$('#special_version ul li').on('click', function(){

		var specialVersionID = this.value,
				specialVersionTitle = this.innerText,
				thisBtn = $('#measurement_range button'),
				nextParam = +thisBtn.attr('id');
		Core.specialVersionID = specialVersionID;


		//set Title to Dropdown
		$('#special_version button').text(specialVersionTitle);

		$.ajax({
			url: Core.ajaxUrl,
			method: 'post',
			data: {
				action_name: 'getMeasurementRangesByEqModeIDAndAccuracyID',
				eq_mode_id: Core.eqModeID,
				accuracy_id: Core.accuracyID
			},
			success: function(data){
				if (data != 'no data'){
					blink(nextParam, '#ABFCB2')
					thisBtn.removeAttr('disabled');
					$('#measurement_range ul').html(data); //append
					$('.jumbotron').html(data);
					reviveNextParam(nextParam);
				} else {
					blink(nextParam, '#FFA0A0');
					$('#measurement_range button').text('нет данных');
				}
			}
		});
	});
}

function reviveMeasurementRange(){
	$('#measurement_range ul li').on('click', function(){

		var measurementRangeID = this.value,
				measurementRangeTitle = this.innerText,
				nextBtn = $('#body_type button'),
				nextParam = +nextBtn.attr('id');
		Core.measurementRangeID = measurementRangeID;

		//set Title to Dropdown
		$('#measurement_range button').text(measurementRangeTitle);

		$.ajax({
			url: Core.ajaxUrl,
			method: 'post',
			data: {
				action_name: 'getBodyTypesByEqModeIDAndSpecialVersionID',
				eq_mode_id: Core.eqModeID,
				special_version_id: Core.specialVersionID
			},
			success: function(data){
				if (data != 'no data'){
					blink(nextParam, '#ABFCB2')
					nextBtn.removeAttr('disabled');
					$('#body_type ul').html(data);
                    $('.jumbotron').html(data);
					 reviveNextParam(nextParam);
				} else {
					blink(nextParam, '#FFA0A0');
					$('#body_type button').text('нет данных');
				}
			}
		});
	});
}

function reviveBodyType(){
	$('#body_type ul li').on('click', function(){

		var bodyTypeID = this.value,
				bodyTypeTitle = this.innerText,
				nextBtn = $('#process_connection button'),
				nextParam = +nextBtn.attr('id');
		Core.bodyTypeID = bodyTypeID;
		Core.bodyTypeTitle = bodyTypeTitle;

		$('#body_type button').text(bodyTypeTitle);

		$.ajax({
			url: Core.ajaxUrl,
			method: 'post',
			data: {
				action_name: 'getProcessConnectionByEqModeIDAndSpecialVersionID',
				eq_mode_id: Core.eqModeID,
				special_version_id: Core.specialVersionID
			},
			success: function(data){
				if (data != 'no data'){
					blink(nextParam, '#ABFCB2')
					nextBtn.removeAttr('disabled');
					$('#process_connection ul').html(data);
					$('.jumbotron').html(data);
					reviveNextParam(nextParam);
				} else {
					blink(nextParam, '#FFA0A0');
					$('#process_connection button').text('нет данных');
				}
			}
		});
	});
}

function reviveProcessConnection(){
	$('#process_connection ul li').on('click', function(){

		var processConnectionID = this.value,
				processConnectionTitle = this.innerText,
				nextBtn = $('#mounting_parts button'),
				nextParam = +nextBtn.attr('id');
		Core.processConnectionID = processConnectionID;

		$('#process_connection button').text(processConnectionTitle);

		console.log(typeof processConnectionTitle)
		var check;
		//
		if ( (check = /K$/i.test(processConnectionTitle)) && (/^PC-SG-[a-zA-Z0-9_]/ == Core.eqModeTitle) || ('PK' == Core.bodyTypeTitle) ){
			//call modalCable
			$('#modalCable').on('shown.bs.modal', function () {
				$('#cableLength').focus();
			});
			$('#modalCable').modal();
		} else if (check){
			$('#modalPulsePipe').modal();
			//call modal pulise pipe
		} else {
			//call function to mounting_parts
		}

/*		$.ajax({
			url: Core.ajaxUrl,
			method: 'post',
			data: {
				action_name: 'getProcessConnectionByEqModeIDAndSpecialVersionID',
				eq_mode_id: Core.eqModeID,
				special_version_id: Core.SpecialVersionID
			},
			success: function(data){
				if (data != 'no data'){
					blink(nextParam, '#ABFCB2')
					nextBtn.removeAttr('disabled');
					$('#process_connection ul').html(data);
					$('.jumbotron').html(data);
					//reviveNextParam(nextParam);
				} else {
					blink(nextParam, '#FFA0A0');
					$('#process_connection button').text('нет данных');
				}
			}
		});*/
	});
}

//Rollback Dropdownds
$('.dropdown ul').on('click', function(){
	var currListID = this.id,
		nextListID = +currListID + 1;


	//if next Dropwdown selected we reset all Dropdonws since next Dropdown
	if ($('button#' + nextListID).text() != ''){
		for (var i = nextListID; i<=9; i++){
			// console.log($('.dropdown button#' + i));
			$('.dropdown button#' + i).attr('disabled','');
			$('.dropdown button#' + i).text('');
			$('.dropdown button#' + i + ' + ul').empty();
		}
	}

});

//Pulse pipe or cable modal
function getFromModal(form){
	var input = $(form).find('input').val(),
		targetBtn = $('button#6');
	if (form.id == 'Cable'){
		Core.cableLength = input;
		targetBtn.append('/K=' + Core.cableLength);
	} else if (form.id == 'PulsePipe'){
		Core.pulsePipeLength = input;
		targetBtn.append('/K=' + Core.pulsePipeLength);
	}
	$('#modal' + form.id).modal('hide');
	console.log(Core);
	//console.log(typeof input);
}


/*
	helpers API
 */

function blink(dropDownID, color){
	var btn = $('button#' + dropDownID);
	btn.animate(
	{
		backgroundColor: color,
		// opacity: 1
	},
	{
		duration: 200,
		complete: function(){
			btn.animate({backgroundColor: '#fff'}, 200)
		}
	});
}

/*
	Temprary
 */
//$('button').removeAttr('disabled');

//$('#pulse_pipe').fadeOut(2000);

// })();