import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import{Observable, throwError } from 'rxjs';
import {Order} from './order';


@Injectable({
  providedIn: 'root'
})
export class OrderServiceService {

  constructor(private http: HttpClient) { }

  sendRequest(data: any): Observable<any>{
      return this.http.post('http://localhost/cs4640/ngphp-post.php', data);
  }

  sendOrder(data): Observable<Order>{
      return this.sendRequest(data);
  }
}
