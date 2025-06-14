import _ from 'lodash';
window._ = _;

import jQuery from 'jquery';
window.$ = jQuery;

import DataTable from 'datatables.net-dt';
window.DataTable = DataTable;

import jszip from 'jszip';
import pdfmake from 'pdfmake';
import pdfFonts from "pdfmake/build/vfs_fonts";
//import DataTable from 'datatables.net-dt';
import 'datatables.net-buttons-dt';
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons/js/buttons.print.mjs';
import 'datatables.net-autofill-dt';	
import 'datatables.net-scroller-dt';
import 'datatables.net-searchbuilder-dt';


DataTable.Buttons.jszip(jszip);
DataTable.Buttons.pdfMake(pdfmake);

// SweetAlert2
// import Swal from 'sweetalert2';
// window.Swal = Swal;npm remove 