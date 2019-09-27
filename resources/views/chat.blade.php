@extends('layouts.master')

@section('main-body')


<!-- <div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading" id="accordion">
                    <span class="glyphicon glyphicon-comment"></span> Chat
                    <div class="btn-group pull-right">
                        <a type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </a>
                    </div>
                </div>
            <div class="panel-collapse collapse" id="collapseOne">
                <div class="panel-body">
                    <chat-messages :messages="messages" :user = "{{ Auth::user() }}" ></chat-messages>
           
                </div>
                <div class="panel-footer">
                

                      <chat-form
                        v-on:messagesent="addMessage"
                        :user="{{ Auth::user() }}"
                    ></chat-form>


                </div>
            </div>
            </div>
        </div>
    </div>
</div>
 -->

                     

        <div class="small-chat-box fadeInRight animated">
   
            <div class="heading" draggable="true">
               
                Chat
            </div>
            <div class="col-md-4 ">

                <div class="heading1" draggable="true">
               
                        Online
                </div>

                     <div class="chat-users">


                                 <!--    <div class="users-list">
                                        <div class="chat-user">
                                            <img class="chat-avatar" src="images/user.png" alt="" >
                                               <span class="pull-right label label-primary">Online</span>
                                            <div class="chat-user-name">
                                                <a href="#">Karl Jordan</a>
                                            </div>
                                        </div>
                                        <div class="chat-user">
                                          <img class="chat-avatar" src="images/user.png" alt="" >
                                             <span class="pull-right label label-primary">Online</span>
                                            <div class="chat-user-name">
                                                <a href="#">Monica Smith</a>
                                            </div>
                                        </div>
                                        <div class="chat-user">
                                            <span class="pull-right label label-primary">Online</span>
                                           <img class="chat-avatar" src="images/user.png" alt="" >
                                            <div class="chat-user-name">
                                                <a href="#">Michael Smith</a>
                                            </div>
                                        </div>



                                    </div> -->
                                     <chat-user v-on:clickUser:="fetchMessages" :onlines="onlines" :user="{{Auth::user()}}" ></chat-user>


                            </div>

               
                
            </div>

           

                 <div class="col-md-8">
            <div class="content">
                 <chat-messages :messages="messages" :user = "{{ Auth::user() }}" :to_id = "to_id" ></chat-messages>


            </div>
            <div class="form-chat">
          <!--       <div class="input-group input-group-sm">
                    <input type="text" class="form-control">
                    <span class="input-group-btn"> <button
                        class="btn btn-primary" type="button">Send
                </button> </span></div> -->

                   <chat-form
                        v-on:messagesent="addMessage"
                        :user="{{ Auth::user() }}" :to_id="to_id"
                    ></chat-form>



            </div>
            </div>

        </div>
        <div id="small-chat">

            <span class="badge badge-warning pull-right">5</span>
            <a class="open-small-chat">
                <i class="fa fa-comments"></i>

            </a>
        </div>



























@endsection