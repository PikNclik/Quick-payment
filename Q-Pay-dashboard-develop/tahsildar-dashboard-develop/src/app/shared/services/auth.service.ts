import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Router } from "@angular/router";
import { Observable, of, tap } from "rxjs";
import { User } from "src/app/models/data/user.model";
import { LoginResponse } from "src/app/models/responses/login.response";
import { DataService } from "./http/data.service";
import { ErrorService } from "./http/error.service";

@Injectable({ providedIn: 'root' })
export class AuthService extends DataService {

  private roles= [
    {id:1,name:"Admin",priority:2},
    {id:2,name:"Customer Support",priority:3},
    {id:3,name: "Super Admin",priority:1}
  ] ;
  private permissionCategories= [
    {id:1,name:"Merchants",text_to_show:"Q-PAY Users"},
    {id:2,name:"Banks Management",text_to_show:"Banks Management"},
    {id:3,name: "Reports",text_to_show:"Reports"},
    {id:4,name: "Terminal accounts",text_to_show:"Terminal accounts"},
    {id:5,name: "Transaction to do",text_to_show:"Settlement Files"},
    {id:6,name: "Customers",text_to_show:"Customers"},
    {id:7,name: "Working days",text_to_show:"Update working days"},
    {id:8,name: "Settings",text_to_show:"Settings"}
  ] ;
  constructor(
    httpClient: HttpClient,
  ) {
    super('', httpClient);
  }

  /**
   * store user object in local-storage
   * @param {User} user user object
   */
  private setUser(user?: User): void {
    if (!user) return;
    localStorage.setItem('user', JSON.stringify(user));
  }

  /**
   * remove user object from local-storage
   */
  public removeUser(): void {
    localStorage.removeItem('user');
    localStorage.removeItem('token');
  }

  /**
   * store jwt in local-storage
   * @param {string} token jwt
   */
  public setAuthToken(token?: string): void {
    localStorage.setItem("token", token || "");
  }

  /**
   * get user object from local-storage
   * @returns {User | null}
   */
  public getUser(): User | undefined {
    const user = localStorage.getItem("user");
    if (user) return JSON.parse(user) as User;
    return undefined;
  }

  public checkRole(role_name: string): boolean{
   
    return (this.roles.find(role => role.id === this.getUser()?.role_id)?.priority || 100) <= (this.roles.find(role => role.name === role_name)?.priority || 1);
  }

  public checkPermission(categoryName: string,permissionName: string): boolean{
    let categoryId=this.permissionCategories.find(a => a.name.toLowerCase()==categoryName.toLowerCase())?.id;
    let check=this.getUser()?.permissions?.filter(a=> a.category_id== categoryId && a.name?.toLowerCase()== permissionName.toLowerCase());
    return (this.getUser()?.role_id == 3)|| (!!check && check.length>0);
  }

  public getUserRoleName(): string{
   
    return  this.roles.find(role => role.id === this.getUser()?.role_id)?.name || "Admin";
  }


  /**
   * get jwt from local-storage
   * @returns {string} jwt
   */
  public getAuthToken(): string {
    return localStorage.getItem("token") || "";
  }
  /**
   * get user role
   * @returns {string | undefined}
   */
  public getUserRole(): number | undefined {
    return this.getUser()?.role_id;
  }
  /**
   * login by send credentials to server
   * @param credentials email and password
   * @returns {Observable<User>} login result
   */
  public login(credentials: { email: string, password: string }): Observable<LoginResponse> {
    return this.post<LoginResponse>('login', credentials).pipe(
      tap((response: LoginResponse) => {
        this.setUser(response.user);
        this.setAuthToken(response.user?.accessToken);
      }),
    );
  }

  /**
   * send logOut request to server and remove user & token from local-stroage
   */
  logOut(): Observable<void> {
    return this.post<any>('logout', '').pipe(tap(() => this.removeUser()));
  }

  /**
   * check if user is loggedIn
   * @returns {boolean}
   */
  isLoggedIn(): Observable<boolean> {
    const user = this.getUser();
    if (user) return of(true);
    return of(false);
  }

  public getPermissionCategories(){
    return this.permissionCategories;
  }
}
