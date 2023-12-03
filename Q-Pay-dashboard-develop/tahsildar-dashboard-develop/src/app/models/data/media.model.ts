import { environment } from "src/environments/environment";

export interface Media {
  fileName?: string;
  originalName?: string;
  fileSizeInBytes?: number;
  mimetype?: string;
  filePath?: string;
  _id?: string;
}

/**
 * get file full path (server baseUrl + fileUrl)
 *
 * @param string file path
 * @returns {string | any} full path
 */
export function getFullPath(string: any) {
  if (!string) return "";
  if (string.toString().includes("http")) return string;
  else return `${environment.baseUrl}/${string}`;
}
