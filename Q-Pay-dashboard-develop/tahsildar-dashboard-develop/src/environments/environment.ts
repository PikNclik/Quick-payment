// This file can be replaced during build by using the `fileReplacements` array.
// `ng build` replaces `environment.ts` with `environment.prod.ts`.
// The list of file replacements can be found in `angular.json`.

const baseUrl = "https://tahsildar-back-dev.8byteslab.com";

export const environment = {
  production: false,
  apiUrl: `${baseUrl}/api`,
  baseUrl: baseUrl,
  perPage: 25,
  dialogWidth: '550px',
  dialogHeight: '750px',
  dateFormat: 'yyyy/MM/dd',
  datetimeFormat: 'yyyy/MM/dd hh:mm a',
  titlePrefix: 'Tahsildar',
};

/*
 * For easier debugging in development mode, you can import the following file
 * to ignore zone related error stack frames such as `zone.run`, `zoneDelegate.invokeTask`.
 *
 * This import should be commented out in production mode because it will have a negative impact
 * on performance if an error is thrown.
 */
// import 'zone.js/plugins/zone-error';  // Included with Angular CLI.