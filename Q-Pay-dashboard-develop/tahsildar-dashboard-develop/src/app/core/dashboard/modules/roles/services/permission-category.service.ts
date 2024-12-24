import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Observable } from "rxjs";
import { PermissionCategory } from "src/app/models/data/permission_category.model";
import { DataService } from "src/app/shared/services/http/data.service";

@Injectable()
export class PermissionCategoryService extends DataService {
  constructor(httpClient: HttpClient) {
    super('permission_category', httpClient);
  }

  public getPermissionCategories(): Observable <any> {
    return this.get<Array<PermissionCategory>>('',{"isPaginate":false,"sort_dir[]":"asc"});
  }

}
