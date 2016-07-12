
// (function(){
	"use strict";

/*
* #On load init
* #Main API
*   - Rollback Dropdown
* #Modal Windows
* 	- Mounting Parts
* 	- Pulse pipe or cable
* 	- More Special Version
* #Generator
* 	- UI Loader
* #Helpders API
* #Temporarily
*/



/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*\
					On load init
\*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/

	$('.dropdown').tooltip({
		container: 'body'
	});
// $('#eq_mode').on('load', function(event, value, caption) {

function getAllEqModes(){
	var whoAmI = $('#eq_mode > button').attr('id');

		$.ajax({
			url: 'http://rainbow2/ajax/',
			method: 'post',
			data: {
				action_name: 'getAllEqMode'
		},
		success: function(data){
			$('.jumbotron #gen').html(data);
			$('#eq_mode ul').html(data);
			reviveEqMode();
		}
	});

}
// });

getAllEqModes();


/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*\
 				main API
\*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/

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
	tubeLength: null,
	anotherMeasurementRange: null,
	secondProcessConnection: null,
	cablePTFELength: null,
	PTFEenvelopeLength: null,
	//end modal field
	valveUnitID: null,
	valveUnitTitle: null,
	weldedElementID: null,
	weldedElementTitle: null,
	braceID: null,
	braceTitle: null,
	countryCodeID: null,
	countryCodeTitle: null,
	//more stuff
	ContOtherSpecVers: {
		currID: '',
		currTitle: '',
		arr: {},
		ids: []
	}
}

var Helpers = {
	Colors: {
		danger: '#FFA0A0',
		success: '#ABFCB2'
	},
	Alerts: {
		danger: '<div class="alert alert-danger">' +
		'<p></p>' +
		'</div>'
	},
	showAlert: function(id, text){
		var a = $('#' + id);
		a.find('p').text(text);
		a.slideDown(500);
		setTimeout(function(){ a.slideUp(300) }, 4000);
	}
}

function reviveNextParam(nextParam){

	switch(nextParam){
		//1 - getAllEqModes
		case 2: reviveAccuracy(); break;
		case 3: reviveSpecialVersion(); break;
		case 4: reviveMeasurementRange(); break;
		case 5: reviveBodyType(); break;
		case 6: reviveProcessConnection(); break;
		//7 -> getValveUnits
		case 8: reviveValveUnit(); break;
		case 9: reviveWeldedElements(); break;
		case 10: reviveBracing(); break;
	}
	// secondDropDown();
}

// function revive(dd_ul, ){
// 	dd_ul.on('click', 'li', function(){

// 	}
// }

function reviveEqMode(){

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

		//#more Special Version
		destroyOtherSpecialVersions();

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
				$('.jumbotron #gen').html(data);
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

		//#more Special Version
		destroyOtherSpecialVersions();

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
					$('.jumbotrone #gen').html(data);
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

		//more spec version
		if (specialVersionTitle != 'без спец. исп.'){
			initOtherSpecVers();
			$('#modalMoreSpecialVersions').modal();
		}

		//Cable PTFE Modal
		if (specialVersionTitle == 'L') {
			$('#modalCablePTFE').modal();
		}

		// PTFE envelope Modal
		if (specialVersionTitle == 'Фт') {
			$('#modalPTFEenvelope').modal();
		}


		//Must '0,4 - 2 В' or '0 - 2 В' for P[CR]-28B
		if ( /P[CR]-28B/.test(Core.eqModeTitle) ) {
			if ( (specialVersionTitle != '0,4 - 2 В') && (specialVersionTitle != '0 - 2 В') ) {
				//init alert-danger if not exist
				if ( !document.getElementById('alert-require-special-version') ) {
					var msg = $.parseHTML(Helpers.Alerts.danger);
					$(msg).attr('id', 'alert-require-special-version');
					$('#config-param').before(msg);
				}

				Helpers.showAlert('alert-require-special-version',
				'Вы обязательно должны выбрать специальное исполнение с указанием выходного сигнала "0,4 - 2 В" или "0 - 2 В"');
				//hide more Special Version
				$('#modalMoreSpecialVersions').modal('hide');

				} else {
					getMeasurementRange();
				}
			} else {
				getMeasurementRange();
		}

		function getMeasurementRange() {
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
				success: function(data) {
					if (data != 'no data'){
						blink(nextParam, '#ABFCB2')
						thisBtn.removeAttr('disabled');
						$('#measurement_range ul').html(data); //append
						//disable header li
						$('li.header a').on('click', function(){ return false; });
						$('.jumbotron #gen').html(data);
						reviveNextParam(nextParam);
					} else {
						blink(nextParam, '#FFA0A0');
						$('#measurement_range button').text('нет данных');
					}
				}
			});
		}

	});
}

function reviveMeasurementRange(){
	$('#measurement_range ul li').on('click', function(){

		var measurementRangeID = this.value,
				measurementRangeTitle = this.innerText,
				unit = $(this).prevAll('.header').first().find('a').text(),
				nextBtn = $('#body_type button'),
				nextParam = +nextBtn.attr('id');
		Core.measurementRangeID = measurementRangeID;


		//set Title to Dropdown
		$('#measurement_range button').text(measurementRangeTitle +' '+ unit);

		//Choice Anoter Measurement Range
		var t = Core.eqModeTitle;
		if (/APC-+/.test(t) || /APR-+/.test(t) || /PC-SG-25S?.Smart/.test(t)){
			initAnotherMeasurementRange();
			$('#modalAnotherMeasurementRange').modal();
			$('#modalAnotherMeasurementRange').on('shown.bs.modal', function () {
				$('#another_measurement_range').focus();
			});
		}
				//Save Default range to Numbers
				var res = measurementRangeTitle.match(Re.mr);
				var arr = Re.filter(res[1], res[4]);
				Re.DefaultRangeFrom = arr[0];
				Re.DefaultRangeTo = arr[1];
				//Save Unit of Default range
				Re.DefaultRangeUnit = unit;

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
				//Manual Exception №2
					if ( /PC-SG-.*/.test(Core.eqModeTitle) ) {
						$('#body_type ul').prepend('<li value="0">без индикатора</li>');
						reviveBodyTypeForPCSG();
					} else {
				//End Exception №2
					 reviveNextParam(nextParam);
						}
					$('.jumbotron #gen').html(data);
				} else {
					blink(nextParam, '#FFA0A0');
				//Manual Exception №2(part2)
					if ( (/PC-SG-.*/.test(Core.eqModeTitle)) || (/PC-28P/.test(Core.eqModeTitle)) ) {
						$('#body_type button').text('без индикатора');
						$('#process_connection button').text(' - ');
						getValveUnits();
					} else {
				//End Exception №2(part2)
					$('#body_type button').text('нет данных');
					}
				}
			}
		});
	});
}

function reviveBodyType() {
	$('#body_type ul li').on('click', function() {

		var bodyTypeID = this.value,
				bodyTypeTitle = this.innerText;
		Core.bodyTypeID = bodyTypeID;
		Core.bodyTypeTitle = bodyTypeTitle;

		$('#body_type button').text(bodyTypeTitle);

		//Type Tube Length
		if (Core.eqModeTitle == 'PC-28P' || Core.eqModeTitle == 'PC-SP-50') {
			$('#modalTube').modal();
		}

		getProcessConnection();
	});
}

//func for Manual Exception №2
function reviveBodyTypeForPCSG() {
	$('#body_type ul li').on('click', function() {

		var bodyTypeID = this.value,
				bodyTypeTitle = this.innerText;
		Core.bodyTypeID = bodyTypeID;
		Core.bodyTypeTitle = bodyTypeTitle;

		$('#body_type button').text(bodyTypeTitle);

		//Type Tube Length
		if (Core.eqModeTitle == 'PC-28P' || Core.eqModeTitle == 'PC-SP-50') {
			$('#modalTube').modal();
		}

		$('#process_connection button').text(' - ');
		//Redirect to ValveUnits, cause PC-SG-.* have not ProcessConnection
		getValveUnits();
	});
}

function getProcessConnection() {
	var thisBtn = $('#process_connection button'),
			thisParam = +thisBtn.attr('id');

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
					blink(thisParam, '#ABFCB2');
					thisBtn.removeAttr('disabled');
					$('#process_connection ul').html(data);
					$('.jumbotron #gen').html(data);
					reviveNextParam(thisParam);
				} else {
					blink(thisParam, '#FFA0A0');
					$('#process_connection button').text('нет данных');
				}
			}
		});
}

function reviveProcessConnection(){
	$('#process_connection ul li').on('click', function(){

		var processConnectionID = this.value,
				processConnectionTitle = this.innerText;
		Core.processConnectionID = processConnectionID;
		Core.processConnectionTitle = processConnectionTitle;

		$('#process_connection button').text(processConnectionTitle);

		//for Second ProcessConnection
		if (Core.eqModeTitle == 'APR-2200') {
			initSecondProcessConnectionModal();
			$('#modalSecondProcessConnection').modal();
		}

		//if ProcessConnection finish on "K"
		if ( /K$/i.test(processConnectionTitle) ) {
			$('#modalPulsePipe').modal();
		}

		//if EqMode finish on "PC-SG-*" or bodyType finish on PK
		if ( (/^PC-SG-[a-zA-Z0-9_]/ == Core.eqModeTitle) || ('PK' == Core.bodyTypeTitle) ){
			//call modalCable
			$('#modalCable').on('shown.bs.modal', function () {
				$('#cableLength').focus();
			});
			$('#modalCable').modal();
		} else {
			//call function to mounting_parts
			getValveUnits();
		}


	});
}

function getValveUnits(thisBtn){

	var thisBtn = $('#valve_unit button'),
			nextParam = 8,
			nextBtn = $('#welded_element button');

			$.ajax({
			url: Core.ajaxUrl,
			method: 'post',
			data: {
				action_name: 'getValveUnitByProcessConnectionID',
				process_connection_id: Core.processConnectionID
			},
			success: function(data){
				if (data != 'no data'){
					blink(7, '#ABFCB2')
					thisBtn.removeAttr('disabled');
					$('#valve_unit ul').html(data);
					$('.jumbotron #gen').html(data);
					reviveNextParam(nextParam);
				} else {
					//blink(nextParam, '#FFA0A0');
					$('#valve_unit button').text('без. вент. блока');
					$('#valve_unit button').attr('disabled', 'disabled');
					//reviveNextParam(nextParam);
					getWeldedElements($('button#8'), 8);

				}
			}
		});

	$('#modalMountingParts').modal();
}

function reviveValveUnit(){
	$('#valve_unit ul li').on('click', function(){
		var valveUnitID = this.value,
			valveUnitTitle = this.innerText,
			nextBtn = $('#welded_element button'),
			nextParam = +nextBtn.attr('id');
		Core.valveUnitID = valveUnitID;
		Core.valveUnitTitle = valveUnitTitle;

		$('#valve_unit button').text(valveUnitTitle);

		getWeldedElements(nextBtn, nextParam);
/*		$.ajax({
			url: Core.ajaxUrl,
			method: 'post',
			data: {
				action_name: 'getWeldedElementByEqModeProcessConnectionValveUnitID',
				eq_mode_id: Core.eqModeID,
				process_connection_id: Core.processConnectionID,
				valve_unit_id: Core.valveUnitID
			},
			success: function(data){
				if (data != 'no data'){
					blink(nextParam, '#ABFCB2')
					nextBtn.removeAttr('disabled');
					$('#welded_element ul').append(data);
					$('.jumbotron').html(data);
					//reviveNextParam(nextParam);
				} else {
					blink(nextParam, '#FFA0A0');
					$('#welded_element button').text('нет данных');
				}
			}
		});*/

	});
}

function getWeldedElements(thisBtn, thisParam){

	var nextParam = 9,
		nextBtn = $('#brace button');
	//Manual Exception №1
	if ( /^CH{0,1}$/.test(Core.processConnectionTitle) && Core.valveUnitTitle == 'без вент. блока'){

		var html = "<li value=\"0\">без монтаж. эл-ов</li>";
			html += "<li value=\"-1\">2 ниппельных вывода 1/4 NPT</li>";

		blink(thisParam, '#ABFCB2')
		thisBtn.removeAttr('disabled');
		$('#welded_element ul').html(html);

	} else {
	//end Manual Exception №1
		$.ajax({
			url: Core.ajaxUrl,
			method: 'post',
			data: {
				action_name: 'getWeldedElementByEqModeProcessConnectionValveUnitID',
				eq_mode_id: Core.eqModeID,
				process_connection_id: Core.processConnectionID,
				valve_unit_id: Core.valveUnitID
			},
			success: function (data) {
				if (data != 'no data') {
					blink(thisParam, '#ABFCB2')
					thisBtn.removeAttr('disabled');
					thisBtn.text('');
					$('#welded_element ul').html(data);
					$('.jumbotron #gen').html(data);
					reviveNextParam(nextParam);
				} else {
					blink(thisParam, '#FFA0A0');
					$('#welded_element button').text('без монтаж. эл-ов');
					$('#welded_element button').attr('disabled', 'disabled');
					getBracing();

				}
			}
		});
	}
}

function reviveWeldedElements(){
	$('#welded_element ul li').on('click', function(){
		var weldedElementID = this.value,
				weldedElementTitle = this.innerText;
		Core.weldedElementID = weldedElementID;
		Core.weldedElementTitle = weldedElementTitle;

		$('#welded_element button').text(weldedElementTitle);

		getBracing();
	});
}

function getBracing(){
	var thisBtn = $('#brace button'),
		thisParam = +thisBtn.attr('id'),
		nextParam = thisParam + 1;

	$.ajax({
		url: Core.ajaxUrl,
		method: 'post',
		data: {
			action_name: 'getBracingByProcessConnectionBodyTypeEqMode',
			process_connection_id: Core.processConnectionID,
			body_type_id: Core.bodyTypeID,
			eq_mode_id: Core.eqModeID,
		},
		success: function (data) {
			if (data != 'no data') {
				blink(thisParam, '#ABFCB2')
				thisBtn.removeAttr('disabled');
				thisBtn.text('');
				$('#brace ul').html(data);
				$('.jumbotron #gen').html(data);
				reviveNextParam(nextParam);
			} else {
				blink(thisParam, '#FFA0A0');
				$('#brace button').text('без крепления');
				$('#brace button').attr('disabled', 'disabled');

			}
		}
	});
}

function reviveBracing(){
		$('#brace ul li').on('click', function(){
				var braceID = this.value,
						braceTitle = this.innerText;
				Core.braceID = braceID;
				Core.braceTitle = braceTitle;

				$('#brace button').text(braceTitle);

				//getBracing();
		});
}

function getCountryCodes(){
	var thisBtn = $('#country_code button'),
			thisParam = +thisBtn.attr('id');

	$.ajax({
		url: Core.ajaxUrl,
		method: 'post',
		data: {
			action_name: 'getAllCountryCodes'
		},
		success: function (data) {
			if (data != 'no data') {
				blink(thisParam, '#ABFCB2')
				thisBtn.removeAttr('disabled');
				thisBtn.text('');
				$('#country_code ul').html(data);
				$('.jumbotron #gen').html(data);

				(function reviveCountryCode(){
					$('#country_code ul li').on('click', function(){
						var countryCodeID = this.value,
								countryCodeTitle = this.innerText;
						Core.countryCodeID = countryCodeID;
						Core.countryCodeTitle = countryCodeTitle;

						thisBtn.text(countryCodeTitle);
					});
				})();
			} else {
				blink(thisParam, '#FFA0A0');
				thisBtn.text('нет данных');
				thisBtn.attr('disabled', 'disabled');

			}
		}
	});
}

/*>>>>>>>>>>>
	--------------> Rollback Dropdownds
 */
$('.dropdown ul').on('click', function(){
	var currListID = this.id,
			nextListID = +currListID + 1,
			nextBtn = $('button#' + nextListID);

	//if next Dropwdown selected we reset all Dropdonws since next Dropdown
	if ( ($(nextBtn).text() != '') && ($(nextBtn).text() != ' - ') ) {
		var dis = '';

		for (var i = nextListID; i <= 11; i++) {
			// console.log($('.dropdown button#' + i));
			$('.dropdown button#' + i).attr('disabled','');
			$('.dropdown button#' + i).text('');
			$('.dropdown button#' + i + ' + ul').empty();
			dis += ' ' + i;
		}
	console.log('Disabled Btns: ' + dis);
	}

	//rollback Modal values
	switch (currListID) {
		case '1':
		case '2':
			Core.ContOtherSpecVers.arr = {};
			Core.ContOtherSpecVers.ids = [];
		case '3':
			Core.PTFEenvelopeLength = null;
			Core.cablePTFELength = null;
		case '4':
			Core.anotherMeasurementRange = null;
		case '5':
			Core.tubeLength = null;
		case '6':
			Core.secondProcessConnection = null;
			Core.pulsePipeLength = null;
			Core.cableLength = null;
			//clear mounting parts
			Core.valveUnitID = null;
			Core.valveUnitTitle = ' - ';
			Core.weldedElementID = null;
			Core.weldedElementTitle = ' - ';
			Core.braceID = null;
			Core.weldedElementTitle = ' - ';
			break;
		default:
	}
});


/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*\
 				Modal Windows
\*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/

/*
	Pulse pipe or cable modal
*/
function getFromModal(form){
	var inputVal = $(form).find('input').val(),
		targetBtn = $('button#6');
	if (form.id == 'Cable'){
		Core.cableLength = inputVal;
		targetBtn.append('/K=' + Core.cableLength);
		getValveUnits();
	} else if (form.id == 'PulsePipe'){
		Core.pulsePipeLength = inputVal;
		targetBtn.append('/K=' + Core.pulsePipeLength);
		getValveUnits();
	} else if (form.id == 'Tube'){
		Core.tubeLength = inputVal;
		targetBtn.append('/L=' + Core.tubeLength);
		getValveUnits();
	} else if (form.id == 'CablePTFE') {
		Core.cablePTFELength = inputVal;
		$('#special_version button').append('=' + Core.cablePTFELength);
	} else if (form.id == 'PTFEenvelope') {
		Core.PTFEenvelopeLength = inputVal;
		$('#special_version button').append('=' + Core.PTFEenvelopeLength);
	}
	$('#modal' + form.id).modal('hide');
}

/*
	Mounting Parts modal
*/
function getFromMountingPartsModal(){
	var flag = true,
		buttons = $.makeArray( $('#mounting-parts button') );
	buttons.forEach(function(item, i, arr){
		if (item.innerText == '') flag = false;
	})

	if (flag == false){
		//Msg exist ? create one and show : show old msg
		if ( !document.getElementById('nfMountingParts') ){
			var msg = '<div id="nfMountingParts" class="alert alert-danger not-filled"><p>Не все поля заполнены</p></div>';
			$(msg).insertBefore( $('#mounting-parts') );
			msg = $('#nfMountingParts');
			msg.slideDown();
			setTimeout(function(){ msg.slideUp() }, 2000);
		} else {
			msg = $('#nfMountingParts');
			msg.slideDown();
			setTimeout(function(){ msg.slideUp() }, 2000);
		}
	} else {
		$('#modalMountingParts').modal('hide');
		//Add mountin parts to Button and revive County Code
		var v = ((Core.valveUnitTitle == undefined) || (Core.valveUnitTitle == 'без вент. блока')) ? '- ' : Core.valveUnitTitle
		var w = ((Core.weldedElementTitle == undefined)  || (Core.weldedElementTitle == 'без монтаж. эл-ов')) ? ' - ' : Core.weldedElementTitle
		var b = ((Core.braceTitle == undefined) || (Core.braceTitle == 'без крепления')) ? ' -' : Core.braceTitle
		$('#mounting_parts button').text( v + '/' + w + '/' + b ).removeAttr('disabled');

		getCountryCodes();
	}
}

/*
	More Special Version Modal
 */
function getFromMoreSpecialVersionsModal() {
	$('#modalMoreSpecialVersions').modal('hide');
}

function initOtherSpecVers() {
	var currSpecialVersions = [],
			cont = $('#modalMoreSpecialVersions').find('#many-spec-ver'),
			btn = ('#spec_ver_2 button');

	//insert Clear Dropdown in container
	cont.html('<div id="" class="dropdown dd-mod dd-mod-spec-ver">'+
							'<button id="btn-more-spec-ver" class="btn btn-default dropdown-toggle btn-conf" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></button>'+
							'<ul class="dropdown-menu">'+
							'</ul>'+
						'</div>'+
						'<i onclick="addSpecVer()" class="fa fa-plus-circle fa-2x add-spec-ver"></i>');
	//assigned him ID
	$( cont ).find('.dropdown').attr('id','spec_ver_2');
	currSpecialVersions = $.parseHTML($('button#3 + ul').html());
	//delete first li with "без спец. исп."
	currSpecialVersions.splice(0,1);
	$('#spec_ver_2 ul').html( currSpecialVersions );
	//Add first SpecialVersion to CurrID and to Caption
	Core.ContOtherSpecVers.currID = currSpecialVersions[0].value;
	Core.ContOtherSpecVers.currTitle = currSpecialVersions[0].innerText;
	$(btn).text(Core.ContOtherSpecVers.currTitle);

	reviveNewSpecVer();
}

function reviveNewSpecVer() {
	$('#spec_ver_2 ul li').on('click', function() {
		var btn = ('#spec_ver_2 button');

		Core.ContOtherSpecVers.currID = this.value,
		Core.ContOtherSpecVers.currTitle = this.innerText;
		$(btn).text(this.innerText);
	});
}

function addSpecVer() {
	var SV = Core.ContOtherSpecVers,
			currTag,
			flag = true;

	//check duplicate with DEFAULT entity
	if (SV.currTitle == $('#special_version button').text()) {
		var msg = $.parseHTML(Helpers.Alerts.danger);

		flag = false;
		$( msg ).find('p').text('Данное специальное исполнение уже было выбрано ранее');
		//bad check, but minimalistic: msg NOT exist ? insert before : show old msg
		if ( $('#modalMoreSpecialVersions .alert-danger')[0] == undefined ) {
			$('#modalMoreSpecialVersions .primary-text').before(msg);
		}

		$('#modalMoreSpecialVersions .alert-danger').slideDown(500);
		setInterval(function(){ $( msg ).slideUp(300) }, 5000);
	}

	//Tag exist in SV.Array?
	$.each(SV.arr, function(index, value) {
		if (index == SV.currID) flag = false;
	});

	if (flag == true) {
		var stareElem = $('.spec-ver-tag[val='+SV.currID+']');

		SV.arr[SV.currID] = SV.currTitle;
		//for BackEnd
		SV.ids.push(SV.currID);

		currTag = $.parseHTML('<div class="spec-ver-tag">' +
														'<span></span><i onclick="delSpecVer(this)" class="fa fa-close"></i>' +
													'</div>');
		$(currTag).attr('val', SV.currID);
		$(currTag).find('span').text(SV.currTitle);
		$('#tag-showcase').append( currTag );
	} else {
		//message about entity was exist
		blink('btn-more-spec-ver', Helpers.Colors.danger);
		stareElem.animate({
			backgroundColor: Helpers.Colors.success
		}, 300, 'swing', function() {
			stareElem.animate({backgroundColor: '#fff'}, 200);
		});
	}

}

function delSpecVer(obj) {
	var SV = Core.ContOtherSpecVers,
			tarElem = $( obj ).parent(),
			tagID = tarElem.attr('val');
	//delete tag
	tarElem.remove();
	//delete elem from Object
	delete SV.arr[tagID];
	SV.ids.forEach(function(item, i, arr) {
		if (item == tagID) delete arr[i];
	});
}

function destroyOtherSpecialVersions() {
	$('#tag-showcase').empty();
	Core.ContOtherSpecVers.arr = {}
}

/*
	Second ProcessConnection Modal
 */
function initSecondProcessConnectionModal() {

	//Add dropdown to DOM
	//WHY: this hardcode for escape Listener called RollbackDropdown
	var htmlDropdown = '<div id="second_process_connection" class="dropdown dd-mod">' +
											'<button class="btn btn-default dropdown-toggle btn-conf" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></button>' +
											'<ul class="dropdown-menu" aria-labelledby="">' +
											'</ul>'+
										 '</div>';
	$('#container-second-process-connection').html(htmlDropdown);

	//Copy list items from ProcessConnection
	var listElem = $('#process_connection ul').html(),
			newDropdown = $('#second_process_connection');
	$(newDropdown).find('ul').html(listElem);

	//Add handler to new list
	$(newDropdown).find('ul li').on('click', function() {
		Core.secondProcessConnection = this.value;
		$(newDropdown).find('button').text(this.innerText);
	});

}

function getFromSecondProcessConnectionModal() {
	if ( $('#second_process_connection button').text() != '' ) {
		$('#modalSecondProcessConnection').modal('hide');
	} else {

		if ( !document.getElementById('alert-second-proccess-connection') ) {
			var msg = '<div id="alert-second-proccess-connection" class="alert alert-danger"><p>Должно быть выбрано второе процессное соединение</p></div>';
			$('#container-second-process-connection').prev().before(msg);
			$('#alert-second-proccess-connection').slideDown(300);
			setTimeout(function(){ $('#alert-second-proccess-connection').slideUp(400)}, 4000 );
		} else {
			$('#alert-second-proccess-connection').slideDown(300);
			setTimeout(function(){ $('#alert-second-proccess-connection').slideUp(400)}, 4000 );
		}

	}
}

/*
 Another Measurement Range Modal
 */
 var Re = {
	mr: /(\(?-?\d+\)?)(\s+)?-(\s+)?(\d+)/,
	match: function(str){
		var res = str.match(Re.mr);
		if (res != null){
			Re.p1 = res[1];
			Re.p2 = res[4];
			return true;
		} else {
			return false;
		}
	},
	filter: function(p1, p2){
		var re = /[()]/g;
		var np1 = +p1.replace(re, '');
		var np2 = +p2.replace(re, '');
		return [np1, np2];
	}
 }

function initAnotherMeasurementRange(){
	var sel = $('#modalAnotherMeasurementRange');
	sel.find('.alert-warning').text('В рамках '+ $('#measurement_range button').text());

	//Confirmation on Enter
	$('#another_measurement_range').off('keypress');
	$('#another_measurement_range').on('keypress', function(e){
			if(e.which == 13){ //Enter key pressed
					$('#btn-another-measurement-range').click(); //Trigger button click event
			}
	});

	//Alerts
	if ( !document.getElementById('alert-another-measurement-range') ){
		var alert = $.parseHTML(Helpers.Alerts.danger);
		$(alert).attr('id', 'alert-another-measurement-range');
		sel.find('.text-primary').before( alert );
	}

}


function getFromAnotherMeasurementRange(){
	var range = $('#another_measurement_range').val();
	//if user nothing Type
	if (range != ''){
		//Check text which user send
		//his input is valid?
		if (Re.match(range) == true){
			//convert/filter Second range
			var arr = Re.filter(Re.p1, Re.p2);
			Re.SecondRangeFrom = arr[0];
			Re.SecondRangeTo = arr[1];
			//Number incoming in Default Range?
			var minDef = Re.DefaultRangeFrom,
			maxDef = Re.DefaultRangeTo,
			minSec = Re.SecondRangeFrom,
			maxSec = Re.SecondRangeTo;
			//Deafault and Second range is the same?
			if ((minDef != minSec) || (maxDef != maxSec)){
				//First number must less then Second
				if (minSec < maxSec){
					if (( (maxDef > minSec) && (minSec >= minDef) ) && ( (maxDef >= maxSec) && (maxSec > minDef) )){
						//write true values to Core
						Core.anotherMeasurementRange = minSec + ' - ' + maxSec + ' ' + Re.DefaultRangeUnit;
						$('#modalAnotherMeasurementRange').modal('hide');
						// alert('ALL CORRECTO');
					} else {
						Helpers.showAlert('alert-another-measurement-range', 'Превышены границы основного диапазона измерения');
					}
				} else {
					Helpers.showAlert('alert-another-measurement-range', 'Начало диапазона должно быть меньше, чем его верхнее значение');
				}
			} else {
				Helpers.showAlert('alert-another-measurement-range', 'В случае совпадения диапазонов - установленный диапазон не указывается');
			}
		} else {
			Helpers.showAlert('alert-another-measurement-range', 'Некорректный диапазон');
		}
	} else {
		Core.anotherMeasurementRange = '';
		$('#modalAnotherMeasurementRange').modal('hide');
	}
}

/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*\
				 Generator
\*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/

var requestInProgress = false;
function generate(){
	var flag = true,
			buttons = $.makeArray( $('#config-param button') );
	buttons.forEach(function(item, i, arr){
		if (item.innerText == '') flag = false;
	})

	if (flag == false){ //!!!!! for test change on '!='
		//Msg Exist ? create one and show : show old message
		if ( !document.getElementById('nfGenerator') ){
			var msg = '<div id="nfGenerator" class="alert alert-danger not-filled"><p>Необходимо заполнить все поля</p></div>';
			$(msg).insertBefore( $('#config-param') );
			msg = $('#nfGenerator');
			msg.slideDown();
			setTimeout(function(){ msg.slideUp() }, 2000);
		} else {
			msg = $('#nfGenerator');
			msg.slideDown();
			setTimeout(function(){ msg.slideUp() }, 2000);
		}
	} else {

		requestInProgress = true;
		//Back-End generate
		$.ajax({
			url: Core.ajaxUrl,
			method: 'post',
			data: {
				action_name: 'generate',
				//dataType: 'json',
				//params: JSON.stringify(Core),
				params: Core
			},
			success: function(data) {
				requestInProgress = false;
				if (data != 'no data'){
					$('.jumbotron #gen').html(data).promise().done( function(){
						$('#generated').animate({
							opacity: 1,
							height: 'show',
						}, 1000)
					} );
					//$('.jumbotron #gen').html(data);
				} else {
					$('.jumbotron #gen').text('data not found');
				}
			},
			error: function(jqXHR, textStatus, errorThrow){
				killLoader(listenerInit);
				$('.jumbotron #gen').text('К сожалению, что-то пошло не так. Запрос не удался. Сконфигурируйте заново.');
			}

		});

		//Front-End generate

	}
}

/*>>>>>>>>>>>
		 ------------> UI Loader
*/
var loaderView = "<div style='display:none' id='loader' class='fa fa-spinner fa-3x fa-pulse'></div>";

var il; //id InitLoader Listener
var cl; //id KillLoader Listener

//init loader
listenerInit();

//API Loader
function initLoader(){
	clearInterval(il);
	$('.jumbotron').append(loaderView);
	$('#loader').fadeIn(500);

	cl = setInterval(function(){
		if (requestInProgress == false)	killLoader(listenerInit);
	}, 200);
}

function killLoader(callback){
	clearInterval(cl);
	$('#loader').fadeOut(500, function(){ $(this).remove() });
	callback();
}

function listenerInit(){
	il = setInterval(function(){
		if (requestInProgress == true) initLoader();
	}, 200)
}


/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*\
			Helpers API
\*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
function blink(dropDownID, color){
	var btn = $('button#' + dropDownID);
	btn.animate(
	{
		backgroundColor: color,
		// opacity: 1
	},
	{
		duration: 400,
		complete: function(){
			btn.animate({backgroundColor: '#fff'}, 200);
		}
	});
}



/*
	Temprary
 */
//$('button').removeAttr('disabled');

//$('#pulse_pipe').fadeOut(2000);

// })();
