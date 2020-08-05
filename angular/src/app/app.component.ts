import { Component } from '@angular/core';
import { Order } from './order';
import {OrderServiceService} from './order-service.service';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {


  constructor(private orderService: OrderServiceService){ }
  title = 'Contact Form';

  confirm_msg = '';
  data_submitted = '';

  orderModel = new Order('', '', '');

  confirmOrder(data) {
     this.confirm_msg = 'Your string is: ' + data.name ;
  }

  responsedata= new Order(null, null, null);

  onSubmit(form : any):void {
     this.data_submitted = form;
     let params= JSON.stringify(form);
     this.orderService.sendOrder(params)
     .subscribe( (data) => {
         this.responsedata=data;
     }, (error) => {
         console.log('Error', error);
     } )
  }

}
