import _ from 'lodash';
window._ = _;

import jQuery from 'jquery';
window.$ = jQuery;

import DataTable from 'datatables.net';
window.DataTable = DataTable;

import jszip from 'jszip';
import pdfmake from 'pdfmake';
//import DataTable from 'datatables.net-dt';
import 'datatables.net-buttons-dt';
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons/js/buttons.print.mjs';

DataTable.Buttons.jszip(jszip);
DataTable.Buttons.pdfMake(pdfmake);
// SweetAlert2
// import Swal from 'sweetalert2';
// window.Swal = Swal;npm remove 