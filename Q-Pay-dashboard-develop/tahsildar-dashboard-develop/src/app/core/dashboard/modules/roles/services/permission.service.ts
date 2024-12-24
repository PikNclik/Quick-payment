import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { Permission } from "src/app/models/data/permission.model";
import { PermissionCategory } from "src/app/models/data/permission_category.model";
import { DataService } from "src/app/shared/services/http/data.service";

@Injectable()
export class PermissionService extends DataService {
  constructor(httpClient: HttpClient) {
    super('permission', httpClient);
  }

  public getPermissions(): Observable <any> {
    return this.get<Array<Permission>>('',{"isPaginate":false,"sort_dir[]":"asc"});
  }

}
