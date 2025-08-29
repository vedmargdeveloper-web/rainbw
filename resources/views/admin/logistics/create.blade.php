<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="{{ asset('resources/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('resources/css/main.css') }}">
        <style type="text/css">
            .swal-icon--error {
                border-color: #f27474;
                -webkit-animation: animateErrorIcon 0.5s;
                animation: animateErrorIcon 0.5s;
            }
            .chosen-container{
                width: max-content!important;
            }

            .swal-icon--error__x-mark {
                position: relative;
                display: block;
                -webkit-animation: animateXMark 0.5s;
                animation: animateXMark 0.5s;
            }

            .swal-icon--error__line {
                position: absolute;
                height: 5px;
                width: 47px;
                background-color: #f27474;
                display: block;
                top: 37px;
                border-radius: 2px;
            }
            .swal-icon--error__line--left {
                -webkit-transform: rotate(45deg);
                transform: rotate(45deg);
                left: 17px;
            }
            .swal-icon--error__line--right {
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg);
                right: 16px;
            }
            @-webkit-keyframes animateErrorIcon {
                0% {
                    -webkit-transform: rotateX(100deg);
                    transform: rotateX(100deg);
                    opacity: 0;
                }
                to {
                    -webkit-transform: rotateX(0deg);
                    transform: rotateX(0deg);
                    opacity: 1;
                }
            }
            @keyframes animateErrorIcon {
                0% {
                    -webkit-transform: rotateX(100deg);
                    transform: rotateX(100deg);
                    opacity: 0;
                }
                to {
                    -webkit-transform: rotateX(0deg);
                    transform: rotateX(0deg);
                    opacity: 1;
                }
            }
            @-webkit-keyframes animateXMark {
                0% {
                    -webkit-transform: scale(0.4);
                    transform: scale(0.4);
                    margin-top: 26px;
                    opacity: 0;
                }
                50% {
                    -webkit-transform: scale(0.4);
                    transform: scale(0.4);
                    margin-top: 26px;
                    opacity: 0;
                }
                80% {
                    -webkit-transform: scale(1.15);
                    transform: scale(1.15);
                    margin-top: -6px;
                }
                to {
                    -webkit-transform: scale(1);
                    transform: scale(1);
                    margin-top: 0;
                    opacity: 1;
                }
            }
            @keyframes animateXMark {
                0% {
                    -webkit-transform: scale(0.4);
                    transform: scale(0.4);
                    margin-top: 26px;
                    opacity: 0;
                }
                50% {
                    -webkit-transform: scale(0.4);
                    transform: scale(0.4);
                    margin-top: 26px;
                    opacity: 0;
                }
                80% {
                    -webkit-transform: scale(1.15);
                    transform: scale(1.15);
                    margin-top: -6px;
                }
                to {
                    -webkit-transform: scale(1);
                    transform: scale(1);
                    margin-top: 0;
                    opacity: 1;
                }
            }
            .swal-icon--warning {
                border-color: #f8bb86;
                -webkit-animation: pulseWarning 0.75s infinite alternate;
                animation: pulseWarning 0.75s infinite alternate;
            }
            .swal-icon--warning__body {
                width: 5px;
                height: 47px;
                top: 10px;
                border-radius: 2px;
                margin-left: -2px;
            }
            .swal-icon--warning__body,
            .swal-icon--warning__dot {
                position: absolute;
                left: 50%;
                background-color: #f8bb86;
            }
            .swal-icon--warning__dot {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                margin-left: -4px;
                bottom: -11px;
            }
            @-webkit-keyframes pulseWarning {
                0% {
                    border-color: #f8d486;
                }
                to {
                    border-color: #f8bb86;
                }
            }
            @keyframes pulseWarning {
                0% {
                    border-color: #f8d486;
                }
                to {
                    border-color: #f8bb86;
                }
            }
            .swal-icon--success {
                border-color: #a5dc86;
            }
            .swal-icon--success:after,
            .swal-icon--success:before {
                content: "";
                border-radius: 50%;
                position: absolute;
                width: 60px;
                height: 120px;
                background: #fff;
                -webkit-transform: rotate(45deg);
                transform: rotate(45deg);
            }
            .swal-icon--success:before {
                border-radius: 120px 0 0 120px;
                top: -7px;
                left: -33px;
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg);
                -webkit-transform-origin: 60px 60px;
                transform-origin: 60px 60px;
            }
            .swal-icon--success:after {
                border-radius: 0 120px 120px 0;
                top: -11px;
                left: 30px;
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg);
                -webkit-transform-origin: 0 60px;
                transform-origin: 0 60px;
                -webkit-animation: rotatePlaceholder 4.25s ease-in;
                animation: rotatePlaceholder 4.25s ease-in;
            }
            .swal-icon--success__ring {
                width: 80px;
                height: 80px;
                border: 4px solid hsla(98, 55%, 69%, 0.2);
                border-radius: 50%;
                box-sizing: content-box;
                position: absolute;
                left: -4px;
                top: -4px;
                z-index: 2;
            }
            .swal-icon--success__hide-corners {
                width: 5px;
                height: 90px;
                background-color: #fff;
                padding: 1px;
                position: absolute;
                left: 28px;
                top: 8px;
                z-index: 1;
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg);
            }
            .swal-icon--success__line {
                height: 5px;
                background-color: #a5dc86;
                display: block;
                border-radius: 2px;
                position: absolute;
                z-index: 2;
            }
            .swal-icon--success__line--tip {
                width: 25px;
                left: 14px;
                top: 46px;
                -webkit-transform: rotate(45deg);
                transform: rotate(45deg);
                -webkit-animation: animateSuccessTip 0.75s;
                animation: animateSuccessTip 0.75s;
            }
            .swal-icon--success__line--long {
                width: 47px;
                right: 8px;
                top: 38px;
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg);
                -webkit-animation: animateSuccessLong 0.75s;
                animation: animateSuccessLong 0.75s;
            }
            @-webkit-keyframes rotatePlaceholder {
                0% {
                    -webkit-transform: rotate(-45deg);
                    transform: rotate(-45deg);
                }
                5% {
                    -webkit-transform: rotate(-45deg);
                    transform: rotate(-45deg);
                }
                12% {
                    -webkit-transform: rotate(-405deg);
                    transform: rotate(-405deg);
                }
                to {
                    -webkit-transform: rotate(-405deg);
                    transform: rotate(-405deg);
                }
            }
            @keyframes rotatePlaceholder {
                0% {
                    -webkit-transform: rotate(-45deg);
                    transform: rotate(-45deg);
                }
                5% {
                    -webkit-transform: rotate(-45deg);
                    transform: rotate(-45deg);
                }
                12% {
                    -webkit-transform: rotate(-405deg);
                    transform: rotate(-405deg);
                }
                to {
                    -webkit-transform: rotate(-405deg);
                    transform: rotate(-405deg);
                }
            }
            @-webkit-keyframes animateSuccessTip {
                0% {
                    width: 0;
                    left: 1px;
                    top: 19px;
                }
                54% {
                    width: 0;
                    left: 1px;
                    top: 19px;
                }
                70% {
                    width: 50px;
                    left: -8px;
                    top: 37px;
                }
                84% {
                    width: 17px;
                    left: 21px;
                    top: 48px;
                }
                to {
                    width: 25px;
                    left: 14px;
                    top: 45px;
                }
            }
            @keyframes animateSuccessTip {
                0% {
                    width: 0;
                    left: 1px;
                    top: 19px;
                }
                54% {
                    width: 0;
                    left: 1px;
                    top: 19px;
                }
                70% {
                    width: 50px;
                    left: -8px;
                    top: 37px;
                }
                84% {
                    width: 17px;
                    left: 21px;
                    top: 48px;
                }
                to {
                    width: 25px;
                    left: 14px;
                    top: 45px;
                }
            }
            
            @-webkit-keyframes animateSuccessLong {
                0% {
                    width: 0;
                    right: 46px;
                    top: 54px;
                }
                65% {
                    width: 0;
                    right: 46px;
                    top: 54px;
                }
                84% {
                    width: 55px;
                    right: 0;
                    top: 35px;
                }
                to {
                    width: 47px;
                    right: 8px;
                    top: 38px;
                }
            }

            @keyframes animateSuccessLong {
                0% {
                    width: 0;
                    right: 46px;
                    top: 54px;
                }
                65% {
                    width: 0;
                    right: 46px;
                    top: 54px;
                }
                84% {
                    width: 55px;
                    right: 0;
                    top: 35px;
                }
                to {
                    width: 47px;
                    right: 8px;
                    top: 38px;
                }
            }

            .swal-icon--info {
                border-color: #c9dae1;
            }

            .swal-icon--info:before {
                width: 5px;
                height: 29px;
                bottom: 17px;
                border-radius: 2px;
                margin-left: -2px;
            }
            .swal-icon--info:after,
            .swal-icon--info:before {
                content: "";
                position: absolute;
                left: 50%;
                background-color: #c9dae1;
            }
            .swal-icon--info:after {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                margin-left: -3px;
                top: 19px;
            }
            .swal-icon {
                width: 80px;
                height: 80px;
                border-width: 4px;
                border-style: solid;
                border-radius: 50%;
                padding: 0;
                position: relative;
                box-sizing: content-box;
                margin: 20px auto;
            }
            .swal-icon:first-child {
                margin-top: 32px;
            }
            .swal-icon--custom {
                width: auto;
                height: auto;
                max-width: 100%;
                border: none;
                border-radius: 0;
            }
            .swal-icon img {
                max-width: 100%;
                max-height: 100%;
            }
            .swal-title {
                color: rgba(0, 0, 0, 0.65);
                font-weight: 600;
                text-transform: none;
                position: relative;
                display: block;
                padding: 13px 16px;
                font-size: 27px;
                line-height: normal;
                text-align: center;
                margin-bottom: 0;
            }
            .swal-title:first-child {
                margin-top: 26px;
            }
            .swal-title:not(:first-child) {
                padding-bottom: 0;
            }
            .swal-title:not(:last-child) {
                margin-bottom: 13px;
            }
            .swal-text {
                font-size: 16px;
                position: relative;
                float: none;
                line-height: normal;
                vertical-align: top;
                text-align: left;
                display: inline-block;
                margin: 0;
                padding: 0 10px;
                font-weight: 400;
                color: rgba(0, 0, 0, 0.64);
                max-width: calc(100% - 20px);
                overflow-wrap: break-word;
                box-sizing: border-box;
            }
            .swal-text:first-child {
                margin-top: 45px;
            }
            .swal-text:last-child {
                margin-bottom: 45px;
            }
            .swal-footer {
                text-align: right;
                padding-top: 13px;
                margin-top: 13px;
                padding: 13px 16px;
                border-radius: inherit;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
            .swal-button-container {
                margin: 5px;
                display: inline-block;
                position: relative;
            }
            .swal-button {
                background-color: #7cd1f9;
                color: #fff;
                border: none;
                box-shadow: none;
                border-radius: 5px;
                font-weight: 600;
                font-size: 14px;
                padding: 10px 24px;
                margin: 0;
                cursor: pointer;
            }
            .swal-button:not([disabled]):hover {
                background-color: #78cbf2;
            }
            .swal-button:active {
                background-color: #70bce0;
            }
            .swal-button:focus {
                outline: none;
                box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(43, 114, 165, 0.29);
            }
            .swal-button[disabled] {
                opacity: 0.5;
                cursor: default;
            }
            .swal-button::-moz-focus-inner {
                border: 0;
            }
            .swal-button--cancel {
                color: #555;
                background-color: #efefef;
            }
            .swal-button--cancel:not([disabled]):hover {
                background-color: #e8e8e8;
            }
            .swal-button--cancel:active {
                background-color: #d7d7d7;
            }
            .swal-button--cancel:focus {
                box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(116, 136, 150, 0.29);
            }
            .swal-button--danger {
                background-color: #e64942;
            }
            .swal-button--danger:not([disabled]):hover {
                background-color: #df4740;
            }
            .swal-button--danger:active {
                background-color: #cf423b;
            }
            .swal-button--danger:focus {
                box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(165, 43, 43, 0.29);
            }
            .swal-content {
                padding: 0 20px;
                margin-top: 20px;
                font-size: medium;
            }
            .swal-content:last-child {
                margin-bottom: 20px;
            }
            .swal-content__input,
            .swal-content__textarea {
                -webkit-appearance: none;
                background-color: #fff;
                border: none;
                font-size: 14px;
                display: block;
                box-sizing: border-box;
                width: 100%;
                border: 1px solid rgba(0, 0, 0, 0.14);
                padding: 10px 13px;
                border-radius: 2px;
                transition: border-color 0.2s;
            }
            .swal-content__input:focus,
            .swal-content__textarea:focus {
                outline: none;
                border-color: #6db8ff;
            }
            .swal-content__textarea {
                resize: vertical;
            }
            .swal-button--loading {
                color: transparent;
            }
            .swal-button--loading ~ .swal-button__loader {
                opacity: 1;
            }
            .swal-button__loader {
                position: absolute;
                height: auto;
                width: 43px;
                z-index: 2;
                left: 50%;
                top: 50%;
                -webkit-transform: translateX(-50%) translateY(-50%);
                transform: translateX(-50%) translateY(-50%);
                text-align: center;
                pointer-events: none;
                opacity: 0;
            }
            .swal-button__loader div {
                display: inline-block;
                float: none;
                vertical-align: baseline;
                width: 9px;
                height: 9px;
                padding: 0;
                border: none;
                margin: 2px;
                opacity: 0.4;
                border-radius: 7px;
                background-color: hsla(0, 0%, 100%, 0.9);
                transition: background 0.2s;
                -webkit-animation: swal-loading-anim 1s infinite;
                animation: swal-loading-anim 1s infinite;
            }
            .swal-button__loader div:nth-child(3n + 2) {
                -webkit-animation-delay: 0.15s;
                animation-delay: 0.15s;
            }
            .swal-button__loader div:nth-child(3n + 3) {
                -webkit-animation-delay: 0.3s;
                animation-delay: 0.3s;
            }
            @-webkit-keyframes swal-loading-anim {
                0% {
                    opacity: 0.4;
                }
                20% {
                    opacity: 0.4;
                }
                50% {
                    opacity: 1;
                }
                to {
                    opacity: 0.4;
                }
            }
            @keyframes swal-loading-anim {
                0% {
                    opacity: 0.4;
                }
                20% {
                    opacity: 0.4;
                }
                50% {
                    opacity: 1;
                }
                to {
                    opacity: 0.4;
                }
            }
            .swal-overlay {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                text-align: center;
                font-size: 0;
                overflow-y: auto;
                background-color: rgba(0, 0, 0, 0.4);
                z-index: 10000;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.3s;
            }
            .swal-overlay:before {
                content: " ";
                display: inline-block;
                vertical-align: middle;
                height: 100%;
            }
            .swal-overlay--show-modal {
                opacity: 1;
                pointer-events: auto;
            }
            .swal-overlay--show-modal .swal-modal {
                opacity: 1;
                pointer-events: auto;
                box-sizing: border-box;
                -webkit-animation: showSweetAlert 0.3s;
                animation: showSweetAlert 0.3s;
                will-change: transform;
            }
            .swal-modal {
                width: 478px;
                opacity: 0;
                pointer-events: none;
                background-color: #fff;
                text-align: center;
                border-radius: 5px;
                position: static;
                margin: 20px auto;
                display: inline-block;
                vertical-align: middle;
                -webkit-transform: scale(1);
                transform: scale(1);
                -webkit-transform-origin: 50% 50%;
                transform-origin: 50% 50%;
                z-index: 10001;
                transition: opacity 0.2s, -webkit-transform 0.3s;
                transition: transform 0.3s, opacity 0.2s;
                transition: transform 0.3s, opacity 0.2s, -webkit-transform 0.3s;
            }
            @media (max-width: 500px) {
                .swal-modal {
                    width: calc(100% - 20px);
                }
            }
            @-webkit-keyframes showSweetAlert {
                0% {
                    -webkit-transform: scale(1);
                    transform: scale(1);
                }
                1% {
                    -webkit-transform: scale(0.5);
                    transform: scale(0.5);
                }
                45% {
                    -webkit-transform: scale(1.05);
                    transform: scale(1.05);
                }
                80% {
                    -webkit-transform: scale(0.95);
                    transform: scale(0.95);
                }
                to {
                    -webkit-transform: scale(1);
                    transform: scale(1);
                }
            }
            @keyframes showSweetAlert {
                0% {
                    -webkit-transform: scale(1);
                    transform: scale(1);
                }
                1% {
                    -webkit-transform: scale(0.5);
                    transform: scale(0.5);
                }
                45% {
                    -webkit-transform: scale(1.05);
                    transform: scale(1.05);
                }
                80% {
                    -webkit-transform: scale(0.95);
                    transform: scale(0.95);
                }
                to {
                    -webkit-transform: scale(1);
                    transform: scale(1);
                }
            }
        </style>
        <style>
                    * {
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                        font-family: sans-serif;
                    }
                    body{
                        background: #fff!important;
                    }
                    .custom-navbar ul.navbar-nav li.nav-item:hover, .custom-navbar ul.navbar-nav li.nav-item.show{
                        z-index: 9999999;
                    }
                    th{
                        text-align: center!important;
                    }
                    .dropdown-menu{
                        z-index: 999999;
                    }
                    img.main-logo{
                        width: 27%;
                    }
                    .light{
                        background-color:  #e2efd9!important;
                    }
                    .dark{
                        background-color:  #d8d8d8!important;
                    }
                    .yellow{
                        background-color:  #ffd965!important;
                    }
                    input[type="number"]::-webkit-outer-spin-button,
                    input[type="number"]::-webkit-inner-spin-button {
                        -webkit-appearance: none;
                        margin: 0;
                    }
                    input[type="number"] {
                        -moz-appearance: textfield;
                    }
                    .td-allocation-input{
                        width: 40px;
                    }
                    .main-table {
                        margin: 10px;
                        height: 340px;
                    }
                    .main-table {

                        overflow: auto;
                    }
                    .main-table table thead{
                            /*width: 1600px;*/
                            position: sticky;
                            top: 1px;
                            width: 100%;
                            background: #fff;
                            z-index: 9999
                    }
                    table {
                        width: 100%;
                        white-space: nowrap;
                    }
                    table.allocation-table {
                        border: unset;
                        table-layout: fixed;
                        width: max-content;
                        margin: 1px;
                    }
                    table.allocation-table td,
                    table.allocation-table th {
                        padding: 5px 5px;
                        border: unset;
                        outline: 1px solid;
                    }
                    table.allocation-table td:first-child {
                        border: unset;
                        text-align: right;
                        width: 120px;
                        outline: unset;
                    }
                    table.allocation-table th:first-child {
                        border: unset;
                        text-align: right;
                        width: 90px;
                        outline: unset;
                    }
                    table.allocation-table tbody tr td:nth-child(5) {
                        width: unset;
                    }
                    table,
                    th,
                    td {
                        border:  1px solid;
                        border-collapse: collapse;
                    }
                    .main-table table,
                    .main-table th,
                    .main-table td {
                        outline:   1px solid;
                        border-collapse: collapse;
                        border: unset!important;
                        padding: 3px 8px;
                    }

                    .middle-table th,
                    .middle-table td{
                        outline:   1px solid;
                        border-collapse: unset;
                        border: unset!important;
                    }
                    .middle-table{
                        padding: 10px;
                    }
                    tbody td {
                        font-size: 10px;
                        padding: 1px 0px;
                    }
                    th {
                        font-size: 10px;
                        padding: 0;
                    }
                    /*table tbody tr td:nth-child(18) {
                        background: #e2efda;
                    }
                    table tbody tr td:nth-child(19) {
                        background: #e2efda;
                    }
                    .background-dynamic-td{
                        background: #e2efda;
                    }
                    table tbody tr td:nth-child(20) {
                        background: #e2efda;
                    }*/
                    /*table tbody tr td:nth-child(21) {
                        background: #e2efda;
                    }*/
                    /*table tbody tr td:nth-child(23) {
                        background: #d9d9d9;
                    }*/
                    .td-background-gray{
                        background: #d9d9d9;
                    }
                   /* table tbody tr td:nth-child(24) {
                        background: #d9d9d9;
                    }*/
                  /*  table tbody tr td:nth-child(22) {
                        background: #e2efda;
                    }
                    .
        */

                  /*  table tbody tr td:nth-child(16) {
                        background: #d9d9d9;
                    }
                    table tbody tr td:nth-child(17) {
                        background: #d9d9d9;
                    }
                    table tbody tr td:nth-child(15) {
                        background: #e2efda;
                    }
                    table tbody tr td:nth-child(14) {
                        background: #d9d9d9;
                    }
                    table tbody tr td:nth-child(12) {
                        background: #d9d9d9;
                    }
                    table tbody tr td:nth-child(13) {
                        background: #ffd966;
                    }
                    table tbody tr td:nth-child(11) {
                        background: #e2efda;
                    }*/

                    /*  table tbody tr td:nth-child(6) {
                    }

                    table tbody tr td:nth-child(5) {
                    }*/

                    table tbody tr td {
                        text-align: center;
                    }
                    .bottom-tables {
                        display: flex;
                        align-items: center;
                        justify-content: space-around;
                    }
                    tr.current-vendor-tr-details {
                        cursor: pointer;
                    }
                    .bottom-tables .right {
                        display: flex;
                        align-items: baseline;
                        justify-content: space-around;
                    }
                    .bottom-tables .left,
                    .bottom-tables .right {
                       /* width: 49%;*/
                    }
                    #btn-allocation{
                        background: #07a87c;
                        color: white;
                        border: 0;
                        padding: 10px;
                        text-transform: uppercase;

                        border-radius: 6px;
                    }
                    .tr-box-shadow{
                        /*box-shadow: 0 0 20px 9px #ccc;*/
                        position: relative;
                        z-index: 99;
                        /*background: unset !important;*/
                    }
                    .tr-box-shadow td{
                        /*font-weight: 600;*/
                        height: 40px;
                        border-top: 2px solid red!important;
                        border-bottom: 2px solid red!important;
                    }
                    .tr-box-shadow td{
                        /*box-shadow: 0 0 20px 9px #ccc;*/
                        /*background: unset !important;*/
                    }
                    .select_booking{
                        cursor: pointer;
                    }
                    input.min-width-20 {
                        width: 36px;
                    }
                    .color-red{
                        background: red !important;
                    }




                     .bottom-tables {
                        display: flex;
                        align-items:
                        unset;
                        justify-content: left;
                        width: 100%;
                    }
                    .bottom-tables .right {
                        display: flex;
                        align-items: baseline;

                    }
                    .bottom-tables .left,
                    .bottom-tables .right {
                       /* width: 49%;*/
                        /*margin-top: 4%;*/

                    }
                    #btn-allocation {
                        background: #07a87c;
                        color: white;
                        border: 0;
                        padding: 10px;
                        text-transform: uppercase;
                        border-radius: 6px;
                    }
                    .tr-box-shadow {
                        /*box-shadow: 0 0 20px 9px #ccc;*/
                        /*background: unset !important;*/
                    }
                    .tr-box-shadow td {
                        /*box-shadow: 0 0 20px 9px #ccc;*/
                        /*background: unset !important;*/
                    }
                    .select_booking {
                        cursor: pointer;
                    }
                    input.min-width-20 {
                        width: 36px;
                    }
                    .fixbg{
                        background color: red!important;
                    }
                    .fix{
                    position: sticky;
                    width: 25px;
                    left: 1px;
                    z-index: 2;
                    background-color: white;
                    outline: 1px solid #000;
                    }
                    .fix2{
                    position: sticky;
                    left: 26px;
                    overflow: hidden;
                    width: 30px;
                    width: 25px;
                    z-index: 2;
                    background-color: white;
                    outline: 1px solid #000;
                    }
                    .fix3{
                        position: sticky;
                        left: 50px;
                        z-index: 2;
                        width: 110px;
                        background-color: white;
                        outline: 1px solid #000;
                    }
                    .fix4{
                    position: sticky;
                    left: 160px;
                    width: 57px;
                    z-index: 2;
                    background-color: white;
                    outline: 1px solid #000;
                    }
                     .fix5{
                    position: sticky;
                    white-space: nowrap;
                    left: 218px;
                    width: 55px;
                    z-index: 2;
                    background-color: white;
                    outline: 1px solid #000;
                    }
                     .fix6{
                    position: sticky;
                    white-space: nowrap;
                    left: 319px;
                    width: 48px;
                    z-index: 2;
                    background-color: white;
                    outline: 1px solid #000;
                    }
                     .fix7{
                    position: sticky;
                    left: 553px;
                    z-index: 2;
                    background-color: white;
                    outline: 1px solid #000;
                    }
                     .fix8{
                    position: sticky;
                    white-space: nowrap;
                    left: 504px;
                    width: 30px;
                    z-index: 2;
                    background-color: white;
                    outline: 1px solid #000;
                    }
                     .fix9{
                    position: sticky;
                    white-space: nowrap;
                    left: 534px;
                    width: 60px;
                    z-index: 2;
                    background-color: white;
                    outline: 1px solid #000;
                    }
                     .fix10{
                    position: sticky;
                    left: 594px;
                    width: 120px;
                    z-index: 2;
                    background-color: white;
                    outline: 1px solid #000;
                    }
                     .fix11{
                    position: sticky;
                    left: 714px;
                    width: 56px;
                    z-index: 2;
                    background-color: white;
                    outline: 1px solid #000;
                    }
                    input[name="remark"]{
                        width: 60px;
                    }
                    .table-select-center{
                        text-align: center;
                        margin-bottom: 10px;
                    }
                    .change-status{
                        text-decoration: none;
                        background: green;
                        color: white;
                        padding: 1px;
                    }
                    .fix7{
                        position: sticky;
                        left: 454px;
                        width: 50px;
                        z-index: 2;
                        background-color: white;
                        outline: 1px solid #000;
                    }
                    .allocation-table2{
                        table-layout: fixed;
                        width: max-content!important;
                        margin: auto;
                    }
                    .bggray{
                        background: #ddd4d4;
                    }
                    #lead_status{
                       width: 50%;
                    }
                    .allocation-table2 thead{}
                    .allocation-table2 thead td{}
                    .allocation-table2 thead th{    padding: 5px 5px;}
                    .allocation-table2 tbody td{    padding: 5px 5px;}
                    .update-row-btn{
                            border: 0;
                            padding: 2px 12px;
                            background: green;
                            color: white;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                            cursor: pointer;
                    }
                    .btn-edit{
                        box-shadow: 0 0 15px #cccc;
                        padding: 6px 10px;
                        text-decoration: none;
                        color: black;
                        text-transform: uppercase;
                        margin-right: 12px;
                        cursor: pointer;
                    }
        </style>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script><!-- CSS -->
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.min.css">
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js"></script>
    </head>
    <style>
        .heightlight{
            color: white;
            background: #FF0000;
        }
        
        .heightlight-old{
            color: white;
            background: #a4a4a4;
        }
    </style>
    <body >
        @include('admin.app.inner')
        <div class="main-table">
            @php
                $vechicle_major_head = App\Models\VehicleMajorHead::all();
                $VechicleIDGenration = App\Models\VechicleIDGenration::all();
                $transports = App\Models\Transport::all();
                
                $customers = App\Models\Customer::where('allocation',1)->get();
                $leads =  App\Models\Lead::where('lead_heads_id',4)->get();
            @endphp
            <table>
                <thead>
                    <tr>
                        <th rowspan="3">S. No.</th>
                        <th rowspan="3">Booking ID</th>
                        <th rowspan="3">Booking Date</th>
                        <th rowspan="3">Client</th>
                        <th rowspan="3">Item</th>
                        <th rowspan="2">0</th>
                        <th rowspan="3">Days</th>
                        <th rowspan="3">Readyness</th>
                        <th rowspan="3">Venue</th>
                        <th rowspan="3">Allocation Date</th>
                        <th rowspan="3">Allocation To</th>
                        <th rowspan="3">Allocation In</th>
                        <th rowspan="3">Transportation Responsibility</th>
                        <th rowspan="3"></th>
                        <th rowspan="3">Vehicle ID</th>
                        <th colspan="6">Transportation Details</th>
                        <th rowspan="2">Driver details</th>
                        <th colspan="6"rowspan="2">Useage Details</th>
                        <th colspan="{{ $vechicle_major_head->where('major',0)->count() }}" rowspan="2">Performance Details </th>
                        <th rowspan="3">Remarks</th>
                        <th rowspan="3">Action</th>                       
                    </tr>
                    <tr>
                       
                        <th rowspan="2">Transport Used</th>
                        <th rowspan="2">Transporter</th>
                        <th rowspan="2">E-Way Bill No.</th>
                        <th colspan="3">Billing Details</th>                    
                    </tr>
                    <tr>
                        <th>Booking Qty</th>
                        <th>Transporter Invoice Date</th>
                        <th>Transporter Invoice No</th>
                        <th>Transportation Amount </th>
                        <th></th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Total Time</th>
                        <th>Trips</th>
                        <th>Kms Driven</th>
                        <th>Battery Consumed</th>
                        @foreach($vechicle_major_head->where('major',0) as $ab)
                            <th>{{ $ab->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach($bookings as $book)
                    @php
                        $venue_name_json   = [];
                        $client_name_json  = [];
                        $venue_name_json   = json_decode($book->allocation->booking->delivery_details,true);
                        $client_name_json  = json_decode($book->allocation->booking->customer_details,true);
                        $venue_name        = $venue_name_json['dvenue_name'] ?? 'Name Not display';
                        $client_name       = $client_name_json['company_name'] ?? 'Name Not display';
                        $total_booking_required = $book->allocation_qty;
                    @endphp
                        {{-- {{ dd(Config::get('app.proccess_to_invoice')) }} --}}
                        @if( $book->allocation->booking->leadstatus->status == Config::get('app.logistic_status') )

                            @if($book->allocation->booking->leadstatus->status != Config::get('app.proccess_to_invoice'))

                                @if(Config::get('app.golf_cart_id') == $book->item_id &&  $book->allocation_qty > 0)

                                    @for($i = 1; $i <= $book->allocation_qty; $i++ )
                                        @php
                                            $unique_id = base64_encode($i.'_'.$book->id);
                                            $old_row_count = App\Models\Logistice::where('vendor_allocation_id',$book->id)->count();
                                            $old_row = App\Models\Logistice::where('uniqueid',$unique_id)->first();
                                            $isChallan = App\Models\Challan::where('unique_id_tr',$unique_id)->first();
                                        @endphp
                                        <tr class="{{ $isChallan ? 'heightlight-old' : '' }}">
                                            <td><input type="radio" class="select-row" name="myradio" > {{ $count++ }}</td>
                                                @if($i==1)
                                                    <td rowspan="{{ $book->allocation_qty }}">{{ $book->allocation->booking_id }}</td>
                                                    <td rowspan="{{ $book->allocation_qty }}">{{ date('d-m-Y',strtotime($book->allocation->billing_date)) ?? '' }}</td>
                                                    <td rowspan="{{ $book->allocation_qty }}">{{ $client_name ?? ''  }}</td>
                                                    <td rowspan="{{ $book->allocation_qty }}">{{ $book->allocation->item ?? '' }}</td>
                                                    <td rowspan="{{ $book->allocation_qty }}" >1 ({{ $book->allocation_qty }}) </td>
                                                    <td rowspan="{{ $book->allocation_qty }}">1</td>
                                                @endif

                                           <td>{{ $book->allocation->booking->readyness ?? '' }}</td>
                                           <td>{{ $venue_name ?? '' }}</td>
                                           <td>{{ date('d-m-Y',strtotime($book->allocation->allocation_date)) ?? ''  }}</td>
                                           <td>{{ $book->vendorfetch->company_name ?? '' }}</td>
                                           <td>{{ $book->allocation->allocation_in ?? '' }}</td>
                                           <td>
                                                <select class="transport-responsibility" name="transport_responsibility">
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}"  {{ $old_row ? ( $old_row->transport_responsibility == $customer->id) ? 'selected' : '' : ''  }}  >{{ $customer->company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="rainbow-checkbox">
                                               <input type="checkbox" name="challan"  class="challan" data-uniqueid="{{ $unique_id }}" {{ $old_row ? ($old_row->challan ==0) ?   'disabled=""' : '' : 'disabled=""' }}  value="{{ $book->allocation->bookings_table_id }}"  {{ $old_row ? ( $old_row->challan == 1) ? 'checked' : '' : ''  }} data-itemid="{{ $book->item_id }}"  />
                                            </td>
                                           <td class="vechicleid">
                                                <select name="vehicle_genrate_id">
                                                    <option>Select</option>
                                                    @foreach($VechicleIDGenration as $vechicleId)
                                                        <option value="{{ $vechicleId->id }}" {{ $old_row ? ($old_row->vehicle_genrate_id == $vechicleId->id) ? 'selected' : '' : ''  }} >{{ $vechicleId->vechicle_id }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                           <td>
                                            <select name="transport_used">
                                                @foreach($transports as $transp)
                                                    <option value="{{ $transp->transport }}" {{ $old_row ? ($old_row->transport_used == $transp->transport) ? 'selected' : '' : ''  }} >{{ $transp->transport }}</option>
                                                @endforeach
                                            </select>
                                           </td>
                                            <td>
                                            <select name="transporter_id">
                                                @foreach($customers as $customer)
                                                    <option {{ $old_row ? ($old_row->transporter_id == $customer->id) ? 'selected' : '' : ''  }} value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                                                @endforeach
                                            </select>
                                            </td>
                                           <td><input type="text" value="{{ $old_row ? $old_row->eway_bill_no : ''  }}"  name="eway_bill_no"></td>
                                           <td><input type="date" value="{{ $old_row ? $old_row->transporter_invoice_date : ''  }}" name="transporter_invoice_date"></td>
                                           <td><input type="text" value="{{ $old_row ? $old_row->transporter_invoice_no : ''  }}" name="transporter_invoice_no"></td>
                                           <td><input type="text" value="{{ $old_row ? $old_row->transport_amount : ''  }}" name="transport_amount"></td>
                                           <td><input type="text" value="{{ $old_row ? $old_row->driver_details : ''  }}" name="driver_details"></td>
                                           <td class="start_time"><input type="time" name="start_time" value="{{ $old_row ? $old_row->start_time : ''  }}"></td>
                                           <td class="end_time" ><input type="time" name="end_time" value="{{ $old_row ? $old_row->end_time : ''  }}"></td>
                                           <td class="total_time"> 
                                                <span class="text-total-time">{{ $old_row ? $old_row->total_time : ''  }}</span>
                                                <input type="hidden" name="total_time" value="{{ $old_row ? $old_row->total_time  : ''  }}">
                                           </td>
                                           <td><input type="text" name="trips" value="{{ $old_row ? $old_row->trips : ''  }}"></td>
                                           <td><input type="text" name="kms_drive" value="{{ $old_row ? $old_row->kms_drive : ''  }}"></td>
                                           <td><input type="text" name="battery_consumed"  value="{{ $old_row ? $old_row->battery_consumed : ''  }}"></td>
                                            @foreach($vechicle_major_head->where('major',0) as $ab)   
                                                @php
                                                    $inner = $vechicle_major_head->where('major',$ab->id);
                                                    $performance_details = $old_row ? json_decode($old_row->performance_details,true) : [];
                                                @endphp
                                                <td>
                                                    @if($old_row)
                                                        @if(isset($performance_details[str_replace(' ','_',$ab->name)]))
                                                                <select class="dynamic-inner-td" name="{{ $ab->id }}" data-name="{{ str_replace(' ','_',$ab->name) }}" multiple="">
                                                                    @foreach($inner as $inn)
                                                                        <option value="{{ $inn->name }}" {{ in_array($inn->name, $performance_details[str_replace(' ','_',$ab->name)]) ? 'selected' : ''  }}>{{ $inn->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                        @else
                                                            <select class="dynamic-inner-td" name="{{ $ab->id }}" data-name="{{ str_replace(' ','_',$ab->name) }}" multiple="">
                                                            @foreach($inner as $inn)
                                                                <option value="{{ $inn->name }}">{{ $inn->name }}</option>
                                                            @endforeach
                                                            </select>
                                                        @endif
                                                    @else
                                                        <select class="dynamic-inner-td" name="{{ $ab->id }}" data-name="{{ str_replace(' ','_',$ab->name) }}" multiple="">
                                                            @foreach($inner as $inn)
                                                                <option value="{{ $inn->name }}">{{ $inn->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </td>
                                            @endforeach
                                           <td><textarea type="text" name="remark">{{ $old_row ? $old_row->remark : ''  }}</textarea></td>
                                           <td>
                                                @if($old_row_count == $total_booking_required)
                                                    <select  name="lead_status" >
                                                            @foreach($leads as $le)
                                                                <option value="">Select</option>
                                                                <option value="{{ $le->id }}">{{ $le->lead ?? '' }}</option>
                                                            @endforeach
                                                    </select>
                                                @endif
                                            <input data-vendorall_id="{{ $book->id }}" data-inquire="{{ $book->allocation->booking->enquire_id }}" 
                                            data-bookingid="{{ $book->Allocation->bookings_table_id ?? '' }}" data-uniqueid="{{ $unique_id }}" type="submit" name="save" class="update-row-btn" /></td>
                                        </tr>
                                    @endfor
                                @endif
                            @endif
                        @endif
                @endforeach
                   
               </tbody>
            </table>

        </div>

        <div class="challan-body"></div>
            <script>
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                });

                $(".challan").change(function()
                  {
                        if($(this).is(':checked')){
                     
                            let id = $(this).val();
                            let item_id = $(this).attr('data-itemid');
                            let unique_id_tr = $(this).attr('data-uniqueid');
                            let selected_vehicleid  =  $(this).parent('.rainbow-checkbox').siblings('td.vechicleid').children('select').val();
                            //console.log(selected_vehicleid);
                            $.ajax({
                                url: '{{ route('logistics.challan') }}',
                                type: 'GET',
                                dataType: 'json',
                                data: {id: id,item_id:item_id,unique_id_tr:unique_id_tr,vehicle_id:selected_vehicleid},
                            })
                            .done(function(data) {
                                if(data.status){
                                    $('.challan-body').html(data.html);
                                }
                                console.log("success");
                            })
                            .fail(function() {
                                console.log("error");
                            })
                            .always(function() {
                                console.log("complete");
                            }); 

                        } else{
                             $(this).prop('checked', false);
                             // alert('xno');
                             $('.challan-body').html('');
                        }
                        
                        $(".challan").change(function () {
                            $(".challan").not(this).prop('checked', false);
                        });
                });
                
                $('body').on('change','.transport-responsibility',function(){
                    let customer_id = $(this).val();
                    let checkbox  = $(this).parent().siblings('td.rainbow-checkbox').find('.challan');
                    if(customer_id == {{ Config::get('app.rainbow_id') }} ){
                        checkbox.prop('disabled',false);
                    }else{
                        checkbox.prop('disabled',true);
                        checkbox.prop('checked', false);
                    }
                });

                $('body').on('change','input[name="end_time"]',function(){
                    let start_date =  $(this).parent('td.end_time').siblings('td.start_time').children('input[name="start_time"]').val();
                    let total_time =  $(this).parent('td.end_time').siblings('td.total_time').children('input[name="total_time"]');
                    let total_time_display = $(this).parent('td.end_time').siblings('td.total_time').children('span.text-total-time');
                        const data = {
                              endTime: $(this).val(),
                              startTime: start_date,
                        }
                        
                        const [startHours, startMinutes] = data.startTime.split(':')
                        const [endHours, endMinutes] = data.endTime.split(':')

                        // creates a Date instance to work with
                        const startDate = new Date()
                        const endDate = new Date()

                        // sets hour, minutes and seconds to startDate
                        startDate.setHours(startHours)
                        startDate.setMinutes(startMinutes)
                        startDate.setSeconds("00")

                        // sets hour, minutes and seconds to endDate
                        endDate.setHours(endHours)
                        endDate.setMinutes(endMinutes)
                        endDate.setSeconds("00")

                        const differenceInMilliseconds = endDate - startDate;
                        const differenceInSeconds = differenceInMilliseconds / 1000
                        const differenceInMinutes = differenceInSeconds / 60;
                        const differenceInHours = differenceInMinutes / 60;
                        //console.log(total_time)
                        console.log(differenceInHours);
                        total_time.val(differenceInHours.toFixed(2));
                        total_time_display.text(differenceInHours.toFixed(2));
                });

                // Save Challan

                $('body').on('click','.btn-save',function(e){
                    e.preventDefault();
                    let supply_address =  $('textarea[name="supply_address"]').val();
                    let challan_date   =  $('input[name="challan_date"]').val();
                    let unique_id_tr   =  $('input[name="unique_id_tr"]').val();
                    let challan_no   =  $('input[name="challan_no"]').val();
                    //let supply_address =  $('#supply_address').val();
                    $.ajax({
                        url: '{{ route('logistics.challan.store') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {supply_address,challan_date,unique_id_tr,challan_no},
                    })
                    .done(function(success) {
                        console.log(success);
                        $('textarea[name="supply_address"]').prop('readonly', true);
                        $('input[name="challan_date"]').prop('readonly', true);
                        $('input[name="challan_date"]').css('background', "#cecdcd");
                        $('textarea[name="supply_address"]').css('background', "#cecdcd");
                        alert('Challan is saved');
                    })
                    .fail(function() {
                        console.log("error2");
                    })
                    .always(function() {
                        console.log("complete");
                    });
                    
                    // console.log(supply_address);
                    // console.log(challan_date);
                    // console.log(unique_id_tr);
                    // console.log(challan_no);
                });

                $('body').on('click','.btn-edit',function(e){
                    e.preventDefault();
                        $('textarea[name="supply_address"]').prop('readonly', false);
                        $('input[name="challan_date"]').prop('readonly', false);
                        $('input[name="challan_date"]').css('background', "#fff");
                        $('textarea[name="supply_address"]').css('background', "#fff");
                    
                });

                $('body').on('click','.update-row-btn',function(){
                    let current_tr = $(this).parents('tr');
                    // console.log(current_tr.find('input[name="challan"]').is(':checked') ? 1 : 0 );
                    // return false;
                    let bookingid = $(this).attr('data-bookingid');
                    let uniqueid = $(this).attr('data-uniqueid');
                    let inquires_id = $(this).attr('data-inquire');
                    let kms_drive =  current_tr.find('input[name="kms_drive"]').val();
                    let lead_status =  current_tr.find('select[name="lead_status"]').val();
                    let transport_responsibility =  current_tr.find('select[name="transport_responsibility"]').val();
                    let vendor_allocation_id =  $(this).data('vendorall_id');
                    let challan =  current_tr.find('input[name="challan"]').is(':checked') ? 1  : 0 ;
                    let vehicle_genrate_id =  current_tr.find('select[name="vehicle_genrate_id"]').val();
                    let transport_used =  current_tr.find('select[name="transport_used"]').val();
                    let transporter_id =  current_tr.find('select[name="transporter_id"]').val();
                    let eway_bill_no =  current_tr.find('input[name="eway_bill_no"]').val();
                    let transporter_invoice_date =  current_tr.find('input[name="transporter_invoice_date"]').val();
                    let transporter_invoice_no =  current_tr.find('input[name="transporter_invoice_no"]').val();
                    let transport_amount =  current_tr.find('input[name="transport_amount"]').val();
                    let driver_details =  current_tr.find('input[name="driver_details"]').val();
                    let start_time =  current_tr.find('input[name="start_time"]').val();
                    let end_time =  current_tr.find('input[name="end_time"]').val();
                    let total_time =  current_tr.find('input[name="total_time"]').val();
                    let trips =  current_tr.find('input[name="trips"]').val();
                    let battery_consumed =  current_tr.find('input[name="battery_consumed"]').val();
                    let remark =  current_tr.find('textarea[name="remark"]').val();
                    // console.log(challan);
                    // return false;
                    let dyanmic_record = [];
                    let dyanmic_record_key = [];

                    $.each(current_tr.find('.dynamic-inner-td'), function(index, val) {
                            let key = $(this).attr('name');
                            let data_name = $(this).attr('data-name');
                            dyanmic_record[index] = $(this).val();
                            dyanmic_record_key[index] = data_name;
                    });

                    let cleanArray = dyanmic_record.filter(function () { return true });
                    let marged = toObject(dyanmic_record_key,cleanArray);
                    // console.log('marge',);
                    $.ajax({
                            url: '{{ route('logistics.store.data') }}',
                            type: 'POST',
                            data: {kms_drive,transport_used,transport_responsibility,vendor_allocation_id,challan,vehicle_genrate_id,transport_used,transporter_id,eway_bill_no,transporter_invoice_no,transporter_invoice_date,transport_amount,driver_details,start_time,end_time,total_time,trips,battery_consumed,remark,marged,uniqueid,bookingid,lead_status,inquires_id},
                            success: function (data) {
                                
                                if(data.final != null){
                                    location.reload();
                                }
                                alert('Successfully Saved...');
                                //console.log('xdj');
                            }
                    });
                });

                function toObject(names, values) {
                        var result = {};
                        for (var i = 0; i < names.length; i++)
                             result[names[i]] = values[i];
                        return result;
                }
                
                $(document).ready(function() {
                    $('body').on('click','.select-row',function(){
                        $('.heightlight').removeClass();
                        console.log($(this).parents('tr').addClass('heightlight'));
                    });
                    $(".dynamic-inner-td").chosen();
                });
            </script>
    </body>
</html>
