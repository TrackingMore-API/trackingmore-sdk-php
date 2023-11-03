<?php


namespace TrackingMore;

class ErrorMessages
{
    const ErrEmptyAPIKey = 'API Key is missing';
    const ErrMissingTrackingNumber      = 'Tracking number cannot be empty';
    const ErrMissingCourierCode         = 'Courier Code cannot be empty';
    const ErrMissingAwbNumber           = 'Awb number cannot be empty';
    const ErrMaxTrackingNumbersExceeded = 'Max. 40 tracking numbers create in one call';
    const ErrEmptyId                    = 'Id cannot be empty';
    const ErrInvalidAirWaybillFormat    = 'The air waybill number format is invalid';

}