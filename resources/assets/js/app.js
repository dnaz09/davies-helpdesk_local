/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('chat-messages', require('./components/ChatMessages.vue'));
Vue.component('chat-form', require('./components/ChatForm.vue'));
Vue.component('chat-user', require('./components/ChatUserOnline.vue'));
Vue.component('chat-upload', require('./components/ChatUpload.vue'));
Vue.component('chat-files', require('./components/ChatFiles.vue'));
Vue.component('chatfile-search', require('./components/ChatFileSearch.vue'));
Vue.component('group-add', require('./components/GroupAdd.vue'));
Vue.component('group-list', require('./components/GroupList.vue'));
Vue.component('group-messages', require('./components/GroupMessages.vue'));
Vue.component('groupchat-form', require('./components/GroupChatForm.vue'));
Vue.component('groupchat-members', require('./components/GroupChatMembers.vue'));
Vue.component('groupchat-addmembers', require('./components/GroupChatAddMembers.vue'));
Vue.component('hrdash', require('./components/HrDashboard.vue'));
Vue.component('itdash', require('./components/ItDashboard.vue'));
Vue.component('asdash', require('./components/AsDashboard.vue'));
Vue.component('mtdash', require('./components/MtDashboard.vue'))
Vue.component('user-search', require('./components/UserSearch.vue'));
Vue.component('group-search', require('./components/GroupSearch.vue'));
Vue.component('to-user', require('./components/ToUser.vue'));
Vue.component('to-group', require('./components/ToGroup.vue'));
Vue.component('group-upload', require('./components/GroupUpload.vue'));
Vue.component('group-files', require('./components/GroupFiles.vue'));
Vue.component('groupfile-search', require('./components/GroupFileSearch.vue'));
Vue.component('chatu-count', require('./components/ChatUnseenCount.vue'));
Vue.component('gchatu-count', require('./components/GroupUnseenCount.vue'));
Vue.component('adminnotif-one', require('./components/AdminNotifOne.vue'));
Vue.component('adminmenu-one', require('./components/AdminMenuOne.vue'));
Vue.component('adminnotif-two', require('./components/AdminNotifTwo.vue'));
Vue.component('adminnotif-three', require('./components/AdminNotifThree.vue'));
Vue.component('adminmenu-three', require('./components/AdminMenuThree.vue'));
Vue.component('hrnotif-one', require('./components/HRNotifOne.vue'));
Vue.component('hrmenu-one', require('./components/HRMenuOne.vue'));
Vue.component('hrnotif-two', require('./components/HRNotifTwo.vue'));
Vue.component('hrmenu-two', require('./components/HRMenuTwo.vue'));
Vue.component('hrnotif-three', require('./components/HRNotifThree.vue'));
Vue.component('hrmenu-three', require('./components/HRMenuThree.vue'));
Vue.component('hrnotif-four', require('./components/HRNotifFour.vue'));
Vue.component('hrmenu-four', require('./components/HRMenuFour.vue'));
Vue.component('hrnotif-five', require('./components/HRNotifFive.vue'));
Vue.component('hrmenu-five', require('./components/HRMenuFive.vue'));
Vue.component('sapnotif', require('./components/SAPNotif.vue'));
Vue.component('sapmenu', require('./components/SAPMenu.vue'));
Vue.component('itnotif', require('./components/ITNotif.vue'));
Vue.component('itmenu', require('./components/ITMenu.vue'));
Vue.component('mynotif', require('./components/MyRequestNotif.vue'));
Vue.component('mymenu', require('./components/MyRequestMenu.vue'));
Vue.component('hrapprovernotif', require('./components/HREmployeeReqApproverNotif.vue'));
Vue.component('hrapprovermenu', require('./components/HREmployeeReqApproverMenu.vue'));

const app = new Vue({
    el: '#app',
    //YUNG MY_ID = AUTH USER
    //USE MY_ID TO VALIDATE EVENTS
    data: {
        // Single chat variables
        messages: [],
        message_id: '',
        onlines: [],
        to_id: '',
        my_id: '',
        ids: [],
        to_user: [],
        sfiles: [],
        sfcount: '',
        sfile_id: '',
        unseen: [],
        unseencount: '',
        // Group chat variables
        groups: [],
        gmessages: [],
        group_id: '',
        uids: [],
        members: [],
        group: '',
        to_group: [],
        files: [],
        fcount: '',
        file_id: '',
        nonmembs: [],
        gunseen: [],
        gunseencount: '',
        // HR variables
        totalworkauth: '',
        totalobp: '',
        totalundertime: '',
        totalrequisition: '',
        workauth_p: '',
        obp_p: '',
        undertime_p: '',
        requisition_p: '',
        pendingobps: [],
        workauths: [],
        undertimes: [],
        reqs: [],
        exitpass_p: '',
        exitpass: [],
        // HR Approver
        emp_req_p: '',
        emp_reqs: [],
        // IT variables
        totals_pending: '',
        totals_returned: '',
        totals_solved: '',
        totalu_pending: '',
        totalu_returned: '',
        totalu_solved: '',
        total_it_pending: '',
        total_it_returned: '',
        total_it_solved: '',
        solved_service: '',
        solved_access: '',
        totals_pending1: '',
        totals_returned1: '',
        totals_solved1: '',
        totalu_pending1: '',
        totalu_returned1: '',
        totalu_solved1: '',
        total_it_pending1: '',
        total_it_returned1: '',
        total_it_solved1: '',
        solved_service1: '',
        solved_access1: '',
        itscount: '',
        its: [],
        // Admin variables
        assetp: '',
        jop: '',
        totalasset: '',
        totaljo: '',
        assetpending: [],
        assetrp: [],
        totalassetrp: '',
        // mam tiff dash
        mtog: '',
        saps: [],
        // my dashboard
        myworks: [],
        myunds: [],
        myitems: [],
        myobps: [],
        myreqs: [],
        myits: [],
        mysum: '',

    },

    created() {
        this.mydashboard();
        this.hrdashboard();
        this.itdashboard();
        this.asdashboard();
        this.mtdashboard();
        this.getMySession();
        this.getAllOnlineUser();
        this.fetchMessages();
        this.getAllGroup();
        this.fetchGroupMessages();
        // this.expireAsset();
        // Logging in Listener
        Echo.channel('users')
            .listen('UserLogged', (e) => {
                this.getAllOnlineUser();
            });
        // Listener for Sending of Message
        Echo.channel('chat')
            .listen('MessageSent', (e) => {
                if (this.ids.includes(e.message.user_id) && this.ids.includes(e.message.to_user_id)) {
                    this.messages.push({
                        message: e.message.message,
                        created_at: e.message.created_at,
                        user: e.user,
                        to_id: this.to_id
                    });
                    if (e.message.to_user_id == this.my_id.id) {
                        this.messageSeen(this.to_id);
                    }
                }
            });
        // Listener for Sending of File Single Chat
        Echo.channel('chat')
            .listen('FileSent', (e) => {
                if (this.my_id.id == e.user.id) {
                    this.getChatFiles(e.user.id);
                    $.playSound("/assets/19475726_notification-bell-sound_by_eskoma_preview.mp3");
                    Push.create("HEY! " + this.my_id.first_name + " " + this.my_id.last_name, {
                        body: e.user_from.first_name + ' ' + e.user_from.last_name +
                            ' Sent you a file: ',
                        icon: '/uploads/users/' + e.user.image,
                        timeout: 0,
                        onClick: function () {
                            // $(this).children().toggleClass('fa-comments').toggleClass('fa-remove');
                            // $('.small-chat-box').toggleClass('active');
                            // $('#gtab-1').removeClass('active');
                            this.close();
                        }
                    });
                    toastr.info('Sent you a file', e.user_from.first_name + ' ' + e.user_from.last_name,
                        {
                            timeOut: 0
                        })
                }
            });
        // Listener for Sending of Message Notification
        Echo.channel('chat')
            .listen('MessageSent', (e) => {
                if (e.message.to_user_id == this.my_id.id) {
                    this.getMySession();
                    this.getAllOnlineUser();
                    var self = this;
                    $.playSound("/assets/19475726_notification-bell-sound_by_eskoma_preview.mp3");
                    if (e.user.image != '') {
                        Push.create("HEY! " + this.my_id.first_name + " " + this.my_id.last_name, {
                            body: e.user.first_name + ' ' + e.user.last_name +
                                ' Messaged you: ' + e.message.message,
                            icon: '/uploads/users/' + e.user.image,
                            timeout: 0,
                            onClick: function () {
                                $('.group').removeClass(this);
                                $('.single').removeClass(this);
                                $('.small-chat-box-group').removeClass(this).hide();
                                $('.small-chat-box-single').addClass('active').show();
                                self.fetchMessages(e.message.user_id);
                                this.close();
                            }
                        });
                        toastr.info(e.message.message, e.user.first_name + ' ' + e.user.last_name,
                            {
                                timeOut: 0,
                                onclick: function () {
                                    $('.group').removeClass(this);
                                    $('.single').removeClass(this);
                                    $('.small-chat-box-group').removeClass(this).hide();
                                    $('.small-chat-box-single').addClass('active').show();
                                    self.fetchMessages(e.message.user_id);
                                }
                            })
                    } else {
                        Push.create("HEY! " + this.my_id.first_name + " " + this.my_id.last_name, {
                            body: e.user.first_name + ' ' + e.user.last_name +
                                ' Messaged you: ' + e.message.message,
                            icon: '/uploads/users/default.jpg',
                            timeout: 0,
                            onClick: function () {
                                $('.group').removeClass(this);
                                $('.single').removeClass(this);
                                $('.small-chat-box-group').removeClass(this).hide();
                                $('.small-chat-box-single').addClass('active').show();
                                self.fetchMessages(e.message.user_id);
                                this.close();
                            }
                        });
                        toastr.info(e.message.message, e.user.first_name + ' ' + e.user.last_name,
                            {
                                timeOut: 0,
                                onclick: function () {
                                    $('.group').removeClass(this);
                                    $('.single').removeClass(this);
                                    $('.small-chat-box-group').removeClass(this).hide();
                                    $('.small-chat-box-single').addClass('active').show();
                                    self.fetchMessages(e.message.user_id);
                                }
                            })
                    }
                }
            });
        // Listener for Users
        Echo.channel('users')
            .listen('UserLogged', (e) => {
                if (e.user.online == 1) {
                    this.onlines.push({
                        active: false,
                        id: e.user.id,
                        first_name: e.user.first_name,
                        last_name: e.user.last_name

                    });
                }
            });
        // Listener for Sending of Group Chat
        Echo.channel('groupchat')
            .listen('GroupMessageSent', (e) => {
                if (this.group_id == e.gmessage.group_message_id) {
                    this.gmessages.push({
                        user: e.user,
                        created_at: e.gmessage.created_at,
                        gmessage: e.gmessage.gmessage,
                        group_id: e.gmessage.group_message_id
                    });
                    this.seenGroupMessage(e.gmessage.group_message_id)
                }
            });
        // Listener for Sending of Group Chat
        Echo.channel('groupchat')
            .listen('GroupFileSent', (e) => {
                if (e.mems.includes(this.my_id.id)) {
                    this.getGroupFiles(group.id)
                    $.playSound("/assets/19475726_notification-bell-sound_by_eskoma_preview.mp3");
                    Push.create("HEY! " + this.my_id.first_name + " " + this.my_id.last_name, {
                        body: e.user.first_name + ' ' + e.user.last_name +
                            ' Sent a file in ' + e.group.group_name,
                        icon: '/uploads/users/' + e.user.image,
                        timeout: 0,
                        onClick: function () {
                            // $(this).children().toggleClass('fa-comments').toggleClass('fa-remove');
                            // $('.small-chat-box').toggleClass('active');
                            // $('#gtab-1').removeClass('active');
                            this.close();
                        }
                    });
                    toastr.info('' + e.group.group_name, e.user.first_name + ' ' + e.user.last_name + ' Sent a file in ',
                        {
                            timeOut: 0
                        })
                }
            });
        // Listener for Sending of Group Chat Notif
        Echo.channel('groupchat')
            .listen('GroupMessageSent', (e) => {
                if (e.members.includes(this.my_id.id)) {
                    var self = this;
                    this.getAllGroup();
                    $.playSound("/assets/19475726_notification-bell-sound_by_eskoma_preview.mp3");
                    if (e.user.image != '') {
                        Push.create("In group " + e.group.group_name, {
                            body: e.user.first_name + ' ' + e.user.last_name + ': ' + e.gmessage.gmessage,
                            icon: '/uploads/users/' + e.user.image,
                            timeout: 0,
                            onClick: function () {
                                $('.single').removeClass(this);
                                $('.group').removeClass(this);
                                $('.small-chat-box-group').addClass('active').show();
                                self.fetchGroupMessages(e.group.id)
                                this.close();
                            }
                        });
                        toastr.info(e.gmessage.gmessage, e.user.first_name + ' ' + e.user.last_name +
                            ' in ' + e.group.group_name,
                            {
                                timeOut: 0,
                                onclick: function () {
                                    $('.single').removeClass(this);
                                    $('.group').removeClass(this);
                                    $('.small-chat-box-group').addClass('active').show();
                                    self.fetchGroupMessages(e.group.id)
                                }
                            })
                    } else {
                        Push.create("In group " + e.group.group_name, {
                            body: e.user.first_name + ' ' + e.user.last_name + ': ' + e.gmessage.gmessage,
                            icon: '/uploads/users/default.jpg',
                            timeout: 0,
                            onClick: function () {
                                $('.single').removeClass(this);
                                $('.group').removeClass(this);
                                $('.small-chat-box-group').addClass('active').show();
                                self.fetchGroupMessages(e.group.id)
                                this.close();
                            }
                        });
                        toastr.info(e.gmessage.gmessage, e.user.first_name + ' ' + e.user.last_name +
                            ' in ' + e.group.group_name,
                            {
                                timeOut: 0,
                                onclick: function () {
                                    $('.single').removeClass(this);
                                    $('.group').removeClass(this);
                                    $('.small-chat-box-group').addClass('active').show();
                                    self.fetchGroupMessages(e.group.id)
                                }
                            })
                    }
                }
            });
        // Listener for Creating of groups
        Echo.channel('groups1')
            .listen('GroupCreated', (e) => {
                if (e.members.includes(this.my_id.id)) {
                    this.getAllGroup();
                    var self = this;
                    $.playSound("/assets/19475726_notification-bell-sound_by_eskoma_preview.mp3");
                    Push.create("HEY! " + this.my_id.first_name + " " + this.my_id.last_name, {
                        body: e.group.group_name +
                            ' thread was created and you are included! Open your group chat box now!',
                        icon: '/assets/img/groupchat.png',
                        timeout: 0,
                        onClick: function () {
                            $('.single').removeClass(this);
                            $('.group').removeClass(this);
                            $('.small-chat-box-group').addClass('active').show();
                            self.fetchGroupMessages(e.group.id)
                            this.close();
                        }
                    });
                    toastr.info('Was created and you are included!', e.group.group_name,
                        {
                            timeOut: 0,
                            onclick: function () {
                                $('.single').removeClass(this);
                                $('.group').removeClass(this);
                                $('.small-chat-box-group').addClass('active').show();
                                self.fetchGroupMessages(e.group.id)
                            }
                        })
                }
            });
        // Listener for Deleting of members
        Echo.channel('removeuser')
            .listen('UsersRemoved', (e) => {
                if (e.members.includes(this.my_id.id)) {
                    this.getAllGroup();
                } else if (e.members == this.my_id.id) {
                    this.getAllGroup();
                }
            });
        // Listener for Adding of members
        Echo.channel('newmember')
            .listen('UserAdded', (e) => {
                if (e.members.includes(this.my_id.id)) {
                    var self = this;
                    this.getAllGroup();
                    $.playSound("/assets/19475726_notification-bell-sound_by_eskoma_preview.mp3");
                    Push.create("HEY! " + this.my_id.first_name + " " + this.my_id.last_name, {
                        body: e.group.group_name +
                            ' thread was created and you are included! Open your group chat box now!',
                        icon: '/assets/img/groupchat.png',
                        timeout: 0,
                        onClick: function () {
                            $('.single').removeClass(this);
                            $('.group').removeClass(this);
                            $('.small-chat-box-group').addClass('active').show();
                            self.fetchGroupMessages(e.group.id)
                            this.close();
                        }
                    });
                    toastr.info('Was created and you are included!', e.group.group_name,
                        {
                            timeOut: 0,
                            onclick: function () {
                                $('.single').removeClass(this);
                                $('.group').removeClass(this);
                                $('.small-chat-box-group').addClass('active').show();
                                self.fetchGroupMessages(e.group.id)
                            }
                        })
                } else if (e.members == this.my_id.id) {
                    this.getAllGroup();
                    $.playSound("/assets/19475726_notification-bell-sound_by_eskoma_preview.mp3");
                    Push.create("HEY! " + this.my_id.first_name + " " + this.my_id.last_name, {
                        body: e.group.group_name +
                            ' thread was created and you are included! Open your group chat box now!',
                        icon: '/assets/img/groupchat.png',
                        timeout: 0,
                        onClick: function () {
                            $('.single').removeClass(this);
                            $('.group').removeClass(this);
                            $('.small-chat-box-group').addClass('active').show();
                            self.fetchGroupMessages(e.group.id)
                            this.close();
                            this.close();
                        }
                    });
                    toastr.info('Was created and you are included!', e.group.group_name,
                        {
                            timeOut: 0,
                            onclick: function () {
                                $('.single').removeClass(this);
                                $('.group').removeClass(this);
                                $('.small-chat-box-group').addClass('active').show();
                                self.fetchGroupMessages(e.group.id)
                            }
                        })
                }
            });
        // IT Request Notification
        Echo.channel('dashboardchannel')
            .listen('ServiceRequestSent', (e) => {
                if (this.my_id.dept_id == 7) {
                    if (e.itrequest.status < 3) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: ' A new IT Request was sent! Click for more details',
                            icon: '/assets/img/laptop_maintenance-512.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/it_request_list/" + e.itrequest.reqit_no + "/details", '_blank');
                                this.close();
                            }
                        });
                        toastr.warning(' A New Request was sent!',
                            'IT REQUEST',
                            {
                                onclick: function () {
                                    window.open("/it_request_list/" + e.itrequest.reqit_no + "/details", '_blank');
                                },
                                timeOut: 0
                            })
                    }
                }
                if (this.my_id.id == e.user.id) {
                    if (e.itrequest.status == 3) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: ' Your IT Request was denied! Click for more details',
                            icon: '/assets/img/laptop_maintenance-512.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/my_request_list/it/" + e.itrequest.reqit_no + "/details", '_blank');
                                this.close();
                            }
                        });
                        toastr.warning(' Request Denied!',
                            'IT REQUEST',
                            {
                                onclick: function () {
                                    window.open("/my_request_list/it/" + e.itrequest.reqit_no + "/details", '_blank');
                                },
                                timeOut: 0
                            })
                    }
                }
            });
        // IT Manager Request Notification
        Echo.channel('dashboardchannel')
            .listen('UserAccessSent', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new IT Request was sent! Click for more details',
                        icon: '/assets/img/laptop_maintenance-512.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/user_access/" + e.req.id + "/details", '_blank');
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'IT REQUEST',
                        {
                            onclick: function () {
                                window.open("/user_access/" + e.req.id + "/details", '_blank');
                            },
                            timeOut: 0
                        })
                }
            });
        // IT superior Request Notification
        Echo.channel('dashboardchannel')
            .listen('UserAccessSentSup', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new IT Request was sent! Click for more details',
                        icon: '/assets/img/laptop_maintenance-512.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/superior_user_access/" + e.req.id + "/details", '_blank');
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'IT REQUEST',
                        {
                            onclick: function () {
                                window.open("/superior_user_access/" + e.req.id + "/details", '_blank');
                            },
                            timeOut: 0
                        })
                }
            });
        // Maam Tiff notif
        Echo.channel('dashboardchannel')
            .listen('MamTiffSent', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new SAP IT Request was sent! Click for more details',
                        icon: '/assets/img/laptop_maintenance-512.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/it_manager/" + e.itrequest.reqit_no + "/mng_details", '_blank');
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'SAP IT REQUEST',
                        {
                            onclick: function () {
                                window.open("/it_manager/" + e.itrequest.reqit_no + "/mng_details", '_blank');
                            },
                            timeOut: 0
                        })
                }
            });
        // Manager SAP notif
        Echo.channel('dashboardchannel')
            .listen('SAPSentToSuperior', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new SAP IT Request was sent! Click for more details',
                        icon: '/assets/img/laptop_maintenance-512.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/sap_manager/" + e.itreq.reqit_no + "/details", '_blank');
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'SAP IT REQUEST',
                        {
                            onclick: function () {
                                window.open("/sap_manager/" + e.itreq.reqit_no + "/details", '_blank');
                            },
                            timeOut: 0
                        })
                }
            });
        // Maam tiff dashboard
        Echo.channel('dashboardchannel')
            .listen('MTDashboardLoader', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    this.mtdashboard()
                }
            });
        // Superior Asset Notification
        Echo.channel('managerchannel')
            .listen('SuperiorAssetSent', (e) => {
                if (this.my_id.id == e.user.superior) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Item Request was sent! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/sup_asset_request/" + e.asset_req.req_no + "/details");
                            this.close();
                        }
                    });
                    toastr.warning('A new Item Request was sent! Click for more details',
                        'ITEM REQUEST',
                        {
                            onclick: function () {
                                window.open("/sup_asset_request/" + e.asset_req.req_no + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Dept Manager Asset Notification
        Echo.channel('adminchannel')
            .listen('AssetRequested', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Item Request was sent! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/mng_itemrequest/" + e.req.req_no + "/details");
                            this.close();
                        }
                    });
                    toastr.warning('A new Item Request was sent! Click for more details',
                        'ITEM REQUEST',
                        {
                            onclick: function () {
                                window.open("/mng_itemrequest/" + e.req.req_no + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Superior OBP Notification
        Echo.channel('managerchannel')
            .listen('ManagerOBPSent', (e) => {
                if (this.my_id.id == e.user.superior) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new OBP Request was sent! Click for more details',
                        icon: '/assets/img/52889-locked-padlock-and-key.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/mngr_obp/" + e.obp.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'OBP REQUEST',
                        {
                            onclick: function () {
                                window.open("/mngr_obp/" + e.obp.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Dept Manager OBP Notification
        Echo.channel('hrchannel')
            .listen('OBPRequestSent', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new OBP Request was sent! Click for more details',
                        icon: '/assets/img/52889-locked-padlock-and-key.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/mng_obp/" + e.obp.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'OBP REQUEST',
                        {
                            onclick: function () {
                                window.open("/mng_obp/" + e.obp.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Superior New Emp Requisition Notif
        Echo.channel('managerchannel')
            .listen('EmployeeReqSent', (e) => {
                if (this.my_id.id == e.user.superior) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Employee Requisition Request was sent! Click for more details',
                        icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/sup_emp_requisition/" + e.er.ereq_no + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Requisition REQUEST',
                        {
                            onclick: function () {
                                window.open("/sup_emp_requisition/" + e.er.ereq_no + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Dept Head New Emp Requisition Notif
        Echo.channel('managerchannel')
            .listen('EmployeeReqSentToDeptHead', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Employee Requisition Request was sent! Click for more details',
                        icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/mng_emp_req/" + e.er.ereq_no + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Requisition REQUEST',
                        {
                            onclick: function () {
                                window.open("/mng_emp_req/" + e.er.ereq_no + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Hr New Emp Requisition Notif
        Echo.channel('managerchannel')
            .listen('EmployeeReqSent', (e) => {
                if (this.my_id.id == 6) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Employee Requisition Request was sent! Click for more details',
                        icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/hrd_emp_req/" + e.er.ereq_no + "/viewdetails");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Requisition REQUEST',
                        {
                            onclick: function () {
                                window.open("/hrd_emp_req/" + e.er.ereq_no + "/viewdetails");
                            },
                            timeOut: 0
                        })
                }
            });
        // Approved by Hr Emp Requisition Notif User 
        Echo.channel('hrchannel')
            .listen('EmployeeReqApprovedHR', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' Your Request was approved by the HR Department! Click for more details',
                        icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/emp_requisition/" + e.er.ereq_no + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' Approved Request!',
                        'Requisition REQUEST',
                        {
                            onclick: function () {
                                window.open("/emp_requisition/" + e.er.ereq_no + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Mam Vicky Notif
        Echo.channel('hrchannel')
            .listen('SentToMamVicky', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A New Employee Requisition was sent! Click for more details',
                        icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/approver_index/" + e.ereq.ereq_no + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' Approved Request!',
                        'Requisition REQUEST',
                        {
                            onclick: function () {
                                window.open("/approver_index/" + e.ereq.ereq_no + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Approved By Mam Vicky
        Echo.channel('hrchannel')
            .listen('ApprovedByMamVicky', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A New Employee Requisition was sent! Click for more details',
                        icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/emp_requisition/" + e.ereq.ereq_no + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' Approved Request!',
                        'Requisition REQUEST',
                        {
                            onclick: function () {
                                window.open("/emp_requisition/" + e.ereq.ereq_no + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Hr Approved by HR Approver Emp Requisition Notif approved
        // Echo.channel('hrchannel')
        //     .listen('EmployeeReqApprovedHR', (e) => {
        //         if(this.my_id.dept_id == 6){
        //             $.playSound("/assets/definite.mp3");
        //             Push.create("HEY! " , {
        //                 body: ' A new Employee Requisition Request was approved! Click for more details',
        //                 icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
        //                 timeout: 0,
        //                 onClick: function () {
        //                     window.open("/hrd_emp_req/"+e.er.ereq_no+"/viewdetails");
        //                     this.close();
        //                 }
        //             });
        //             toastr.warning(' Approved Request!',
        //                     'Requisition REQUEST', 
        //                     {
        //                         onclick: function (){
        //                             window.open("/hrd_emp_req/"+e.er.ereq_no+"/viewdetails");
        //                         },
        //                         timeOut: 0
        //                     }) 
        //         }
        //     });
        // Hr Approver Emp Requisition Notif
        Echo.channel('hrchannel')
            .listen('EmployeeReqApprovedSup', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Employee Requisition Request was sent! Click for more details',
                        icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/hrd_emp_req/" + e.er.ereq_no + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Requisition REQUEST',
                        {
                            onclick: function () {
                                window.open("/hrd_emp_req/" + e.er.ereq_no + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // SUperior Requisition Notification
        Echo.channel('managerchannel')
            .listen('ManagerReqSent', (e) => {
                if (this.my_id.id == e.user.superior) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Requisition Request was sent! Click for more details',
                        icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/mngr_requisition/" + e.req.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Requisition REQUEST',
                        {
                            onclick: function () {
                                window.open("/mngr_requisition/" + e.req.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Dept Manager Requisition Notification
        Echo.channel('hrchannel')
            .listen('RequisitionRequested', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Requisition Request was sent! Click for more details',
                        icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/mng_requisition/" + e.req.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Requisition REQUEST',
                        {
                            onclick: function () {
                                window.open("/mng_requisition/" + e.req.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Manager Undertime Notification
        Echo.channel('managerchannel')
            .listen('ManagerUndertimeSent', (e) => {
                if (this.my_id.id == e.user.superior) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Leave Request was sent! Click for more details',
                        icon: '/assets/img/61436-black-clock.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/mngr_undertime/" + e.undertime.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Leave REQUEST',
                        {
                            onclick: function () {
                                window.open("/mngr_undertime/" + e.undertime.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Superior Work Auth Notification
        Echo.channel('managerchannel')
            .listen('ManagerWorkAuthSent', (e) => {
                if (this.my_id.id == e.user.superior) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Work Authorization Request was sent! Click for more details',
                        icon: '/assets/img/thumbs-up-logo-3d8b1b37565b5e36-512x512.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/sup_work_authorization/" + e.work.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Work Authorization REQUEST',
                        {
                            onclick: function () {
                                window.open("/sup_work_authorization/" + e.work.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Dept Manager Work Auth Notification
        Echo.channel('hrchannel')
            .listen('WorkAuthRequested', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Work Authorization Request was sent! Click for more details',
                        icon: '/assets/img/thumbs-up-logo-3d8b1b37565b5e36-512x512.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/mng_work_authorization/" + e.work.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Work Authorization REQUEST',
                        {
                            onclick: function () {
                                window.open("/mng_work_authorization/" + e.work.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // HR Work Auth Notification
        Echo.channel('managerchannel')
            .listen('ManagerWorkAuthSent', (e) => {
                if (this.my_id.dept_id == 6) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Work Authorization Request was sent! Click for more details',
                        icon: '/assets/img/thumbs-up-logo-3d8b1b37565b5e36-512x512.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/hrd_work_authorization/" + e.work.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Work Authorization REQUEST',
                        {
                            onclick: function () {
                                window.open("/hrd_work_authorization/" + e.work.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // User Work Auth Notification
        Echo.channel('hrchannel')
            .listen('WorkAuthApprovedPerson', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' Work Authorization was approved! Click for more details',
                        icon: '/assets/img/thumbs-up-logo-3d8b1b37565b5e36-512x512.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/tagged_request_list/" + e.work.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' Work Authorization was approved!',
                        'Work Authorization REQUEST',
                        {
                            onclick: function () {
                                window.open("/tagged_request_list/" + e.work.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // OBP HR Notification
        Echo.channel('hrchannel')
            .listen('OBPSent', (e) => {
                if (this.my_id.dept_id == 6) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new OBP Request was sent! Click for more details',
                        icon: '/assets/img/52889-locked-padlock-and-key.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/hrd_obp/" + e.obp.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New OBP Request was sent!',
                        'OBP REQUEST',
                        {
                            onclick: function () {
                                window.open("/hrd_obp/" + e.obp.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // OBP Request User Approved
        Echo.channel('hrchannel')
            .listen('OBPReqApproved', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' Your OBP Request has been approved by the HR department!' +
                            ' Click for more details',
                        icon: '/assets/img/52889-locked-padlock-and-key.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/obp/" + e.obp.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' Your OBP Request has been approved by the HR department!',
                        'OBP REQUEST',
                        {
                            onclick: function () {
                                window.open("/obp/" + e.obp.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Exit Pass HR notif
        Echo.channel('hrchannel')
            .listen('ExitPassSent', (e) => {
                if (this.my_id.dept_id == 6) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: 'A new Exit Pass request was sent!' +
                            ' Click for more details',
                        icon: '/assets/img/52889-locked-padlock-and-key.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/hrd_exit_list/" + e.exit.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Exit Pass Request was sent!',
                        'EXIT PASS',
                        {
                            onclick: function () {
                                window.open("/hrd_exit_list/" + e.exit.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Exit Pass User Notif
        Echo.channel('hrchannel')
            .listen('ExitPassApproved', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: 'Your Exit Pass has been approved!' +
                            ' Click for more details',
                        icon: '/assets/img/52889-locked-padlock-and-key.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/emp_exit_pass/" + e.exit.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' Your Exit pass has been approved!',
                        'EXIT PASS',
                        {
                            onclick: function () {
                                window.open("/emp_exit_pass/" + e.exit.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Requisition HR Notification
        Echo.channel('hrchannel')
            .listen('ReqSent', (e) => {
                if (e.req.sup_action == 2) {
                    if (this.my_id.dept_id == 6) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: ' A new Requisition Request was sent! Click for more details',
                            icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/hrd_requisition/" + e.req.rno + "/details");
                                this.close();
                            }
                        });
                        toastr.warning(' A New Request was sent!',
                            'Requisition REQUEST',
                            {
                                onclick: function () {
                                    window.open("/hrd_requisition/" + e.req.rno + "/details");
                                },
                                timeOut: 0
                            })
                    }
                }
            });
        // Requisition Notif to user
        Echo.channel('hrchannel')
            .listen('ReqSent', (e) => {
                if (e.req.sup_action == 2) {
                    if (this.my_id.id == e.req.user_id) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: 'Your Request was sent to the HR department! Click for more details',
                            icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/requisition/" + e.req.rno + "/details");
                                this.close();
                            }
                        });
                        toastr.warning(' Your Request was approved!',
                            'Requisition REQUEST',
                            {
                                onclick: function () {
                                    window.open("/requisition/" + e.req.rno + "/details");
                                },
                                timeOut: 0
                            })
                    }
                }
                if (e.req.sup_action == 3) {
                    if (this.my_id.id == e.req.user_id) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: 'Your Request was denied by your superior! Click for more details',
                            icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/requisition/" + e.req.rno + "/details");
                                this.close();
                            }
                        });
                        toastr.warning(' Your Request was denied!',
                            'Requisition REQUEST',
                            {
                                onclick: function () {
                                    window.open("/requisition/" + e.req.rno + "/details");
                                },
                                timeOut: 0
                            })
                    }
                }
            });
        // Requisition Req User Notif
        // Echo.channel('hrchannel')
        //     .listen('ReqSent', (e) => {
        //         if(this.my_id.id == e.req.user_id){
        //             $.playSound("/assets/definite.mp3");
        //             Push.create("HEY! " , {
        //                 body: ' Your Requisition Request has been approved by your superior!' +
        //                 ' Click for more details',
        //                 icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
        //                 timeout: 0,
        //                 onClick: function () {
        //                     window.open("/requisition/"+ e.req.rno +"/details");
        //                     this.close();
        //                 }
        //             });
        //             toastr.warning(' Your Requisition Request has been approved by your superior!', 
        //                     'Requisition REQUEST', 
        //                     {
        //                         onclick: function (){
        //                             window.open("/requisition/"+ e.req.rno +"/details");
        //                         },
        //                         timeOut: 0
        //                     })
        //         }
        //     });
        // Requisition Req Notif User Approved
        Echo.channel('hrchannel')
            .listen('ReqApproved', (e) => {
                if (this.my_id.id == e.req.user_id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' Your Requisition Request has been approved by the HR department!' +
                            ' Click for more details',
                        icon: '/assets/img/c895a61e637f53ac91d5faf634c84794-cube-logo-geometric-polygonal-by-vexels.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/requisition/" + e.req.rno + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' Your Requisition Request has been approved by the HR department!',
                        'Requisition REQUEST',
                        {
                            onclick: function () {
                                window.open("/requisition/" + e.req.rno + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Undertime HR Notification
        Echo.channel('hrchannel')
            .listen('UndertimeSent', (e) => {
                if (this.my_id.dept_id == 6) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Leave Request was sent! Click for more details',
                        icon: '/assets/img/61436-black-clock.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/hrd_undertime/" + e.undertime.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Leave REQUEST',
                        {
                            onclick: function () {
                                window.open("/hrd_undertime/" + e.undertime.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Undertime Dept Manager Notification
        Echo.channel('hrchannel')
            .listen('UndertimeRequested', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Leave Request was sent! Click for more details',
                        icon: '/assets/img/61436-black-clock.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/mng_undertime/" + e.undertime.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Leave REQUEST',
                        {
                            onclick: function () {
                                window.open("/mng_undertime/" + e.undertime.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Undertime Req User Approved
        Echo.channel('hrchannel')
            .listen('UndertimeApproved', (e) => {
                if (this.my_id.id == e.undertime.user_id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' Your Leave Request has been approved!' +
                            ' Click for more details',
                        icon: '/assets/img/61436-black-clock.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/undertime/" + e.undertime.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' Your Leave Request has been approved!',
                        'Leave REQUEST',
                        {
                            onclick: function () {
                                window.open("/undertime/" + e.undertime.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Work Auth Notification
        Echo.channel('hrchannel')
            .listen('WorkAuthSent', (e) => {
                if (this.my_id.dept_id == 6) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Work Authorization Request was sent! Click for more details',
                        icon: '/assets/img/thumbs-up-logo-3d8b1b37565b5e36-512x512.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/hrd_work_authorization/" + e.work.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Work Authorization REQUEST',
                        {
                            onclick: function () {
                                window.open("/hrd_work_authorization/" + e.work.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Work Auth User Notif
        Echo.channel('hrchannel')
            .listen('WorkAuthSent', (e) => {
                if (this.my_id.dept_id == e.work.user_id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' Your Work Authorization Request has been approved by your superior!'
                            + 'Click for more details',
                        icon: '/assets/img/thumbs-up-logo-3d8b1b37565b5e36-512x512.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/work_authorization/" + e.work.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' Your Work Authorization Request has been approved by your superior!',
                        'Work Authorization REQUEST',
                        {
                            onclick: function () {
                                window.open("/work_authorization/" + e.work.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Work Auth Req User Approved
        Echo.channel('hrchannel')
            .listen('WorkAuthApproved', (e) => {
                if (this.my_id.id == e.work.user_id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' Your Work Authorization Request has been approved by the HR department!'
                            + 'Click for more details',
                        icon: '/assets/img/thumbs-up-logo-3d8b1b37565b5e36-512x512.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/work_authorization/" + e.work.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' Your Work Authorization Request has been approved by your superior!',
                        'Work Authorization REQUEST',
                        {
                            onclick: function () {
                                window.open("/work_authorization/" + e.work.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Hr Dashboard
        Echo.channel('hrchannel')
            .listen('HrDashboardLoader', (e) => {
                if (this.my_id.dept_id == 6) {
                    $.playSound("/assets/definite.mp3");
                    this.hrdashboard();
                }
            });
        Echo.channel('dashboardchannel')
            .listen('ItDashboardLoader', (e) => {
                if (this.my_id.dept_id == 7) {
                    $.playSound("/assets/definite.mp3");
                    this.itdashboard();
                }
            });
        Echo.channel('adminchannel')
            .listen('AdminDashboardLoader', (e) => {
                if (this.my_id.dept_id == 1) {
                    $.playSound("/assets/definite.mp3");
                    this.asdashboard();
                }
            });
        // Admin Room Request notif
        Echo.channel('adminchannel')
            .listen('SendRoomRequest', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' There is a new Room Reservation Request! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/room_request_list/" + e.req.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' New Request!',
                        'ROOM REQUEST',
                        {
                            onclick: function () {
                                window.open("/room_request_list/" + e.req.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Admin close Room Request notif
        Echo.channel('adminchannel')
            .listen('RoomRequestClosed', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' Your Room Reservation Request was closed! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/room_reqs/" + e.req.id);
                            this.close();
                        }
                    });
                    toastr.warning('Request closed!',
                        'ROOM REQUEST',
                        {
                            onclick: function () {
                                window.open("/room_reqs/" + e.req.id);
                            },
                            timeOut: 0
                        })
                }
            });
        // User Room Request notif
        Echo.channel('adminchannel')
            .listen('ChangeStatusRoomRequest', (e) => {
                if (this.my_id.id == e.user.id) {
                    if (e.req.approval == 2) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: ' Your Room Reservation Request was approved! Click for more details',
                            icon: '/assets/img/24048-paper-clip-outline5.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/room_reqs/" + e.req.id);
                                this.close();
                            }
                        });
                        toastr.warning(' Your request was Approved!',
                            'ROOM REQUEST',
                            {
                                onclick: function () {
                                    window.open("/room_reqs/" + e.req.id);
                                },
                                timeOut: 0
                            })
                    }
                    if (e.req.approval == 3) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: ' Your Room Reservation Request was denied! Click for more details',
                            icon: '/assets/img/24048-paper-clip-outline5.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/room_reqs/" + e.req.id);
                                this.close();
                            }
                        });
                        toastr.warning(' Your request was Denied!',
                            'ROOM REQUEST',
                            {
                                onclick: function () {
                                    window.open("/room_reqs/" + e.req.id);
                                },
                                timeOut: 0
                            })
                    }
                }
            });
        // Admin Supply Request notif
        Echo.channel('adminchannel')
            .listen('SuppReqSent', (e) => {
                if (this.my_id.dept_id == 1) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: e.user.first_name + ' ' + e.user.last_name + ' Sent a Supply Request! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/supplies_request/" + e.supp.req_no + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(e.user.first_name + ' ' + e.user.last_name + ' Sent a New Request!',
                        'Supply REQUEST',
                        {
                            onclick: function () {
                                window.open("/supplies_request/" + e.supp.req_no + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Admin Asset Request Notif
        Echo.channel('adminchannel')
            .listen('AssetReqSent', (e) => {
                if (this.my_id.dept_id == 1) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Item Request was sent! Click for more details',
                        icon: '/assets/img/5167-shake-hands2.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/asset_request/" + e.req.req_no + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(e.user.first_name + ' ' + e.user.last_name + ' Sent a New Request!',
                        'ITEM REQUEST',
                        {
                            onclick: function () {
                                window.open("/asset_request/" + e.req.req_no + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // User Asset Request Notif
        Echo.channel('adminchannel')
            .listen('AssetReqSent', (e) => {
                if (this.my_id.id == e.req.user_id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' The Item Request that you have sent was approved by your superior!' +
                            ' Click for more details',
                        icon: '/assets/img/5167-shake-hands2.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/my_request_list/asset/" + e.req.req_no + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' Your request was approved by your superior!',
                        'Asset REQUEST',
                        {
                            onclick: function () {
                                window.open("/my_request_list/asset/" + e.req.req_no + "/details");
                            },
                            timeOut: 0,
                        })
                }
            });
        // User Asset Request approved notif
        Echo.channel('adminchannel')
            .listen('AssetReqApproved', (e) => {
                if (this.my_id.id == e.req.user_id) {
                    Push.create("HEY! ", {
                        body: ' The Item Request that you have sent has been closed!' +
                            ' Click for more details',
                        icon: '/assets/img/5167-shake-hands2.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/my_request_list/asset/" + e.req.req_no + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' The Asset Request that you have sent has been closed! Click for more details',
                        'ITEM REQUEST',
                        {
                            onclick: function () {
                                window.open("/my_request_list/asset/" + e.req.req_no + "/details");
                            },
                            timeOut: 0,
                        })
                }
            });
        // User Job Order Notif
        Echo.channel('adminchannel')
            .listen('JobOrderStatusToggler', (e) => {
                if (this.my_id.id == e.jo.user_id) {
                    if (e.jo.jo_status == 4) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: 'Your Job Order Request has been changed to ongoing! ' +
                                ' Click for more details',
                            icon: '/assets/img/5167-shake-hands2.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/job_order_user/" + e.jo.id + "/details");
                                this.close();
                            }
                        });
                        toastr.warning(' Request Ongoing!',
                            'JOB ORDER',
                            {
                                onclick: function () {
                                    window.open("/job_order_user/" + e.jo.id + "/details");
                                },
                                timeOut: 0
                            })
                    }
                    if (e.jo.jo_status == 2) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: 'Your Job Order Request is done! ' +
                                ' Click for more details',
                            icon: '/assets/img/5167-shake-hands2.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/job_order_user/" + e.jo.id + "/details");
                                this.close();
                            }
                        });
                        toastr.warning(' Request Done!',
                            'JOB ORDER',
                            {
                                onclick: function () {
                                    window.open("/job_order_user/" + e.jo.id + "/details");
                                },
                                timeOut: 0
                            })
                    }
                }
                if (this.my_id.dept_id == 1) {
                    if (e.jo.jo_status == 4) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: 'A Job Order Request was moved from done to ongoing! ' +
                                ' Click for more details',
                            icon: '/assets/img/5167-shake-hands2.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/job_order_admin/" + e.jo.id + "/details");
                                this.close();
                            }
                        });
                        toastr.warning(' Request Ongoing!',
                            'JOB ORDER',
                            {
                                onclick: function () {
                                    window.open("/job_order_admin/" + e.jo.id + "/details");
                                },
                                timeOut: 0
                            })
                    }
                }
            });
        // Job Order User Notif
        Echo.channel('adminchannel')
            .listen('JOReqSent', (e) => {
                if (this.my_id.id == e.jo.user_id) {
                    if (e.jo.status == 2) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: 'Your Job Order Request has been approved by your superior! ' +
                                ' Click for more details',
                            icon: '/assets/img/5167-shake-hands2.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/job_order_user/" + e.jo.id + "/details");
                                this.close();
                            }
                        });
                        toastr.warning(' Request Approved!',
                            'JOB ORDER',
                            {
                                onclick: function () {
                                    window.open("/job_order_user/" + e.jo.id + "/details");
                                },
                                timeOut: 0
                            })
                    } else {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: 'Your Job Order Request has been denied by your superior! ' +
                                ' Click for more details',
                            icon: '/assets/img/5167-shake-hands2.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/job_order_user/" + e.jo.id + "/details");
                                this.close();
                            }
                        });
                        toastr.warning(' Request Denied!',
                            'JOB ORDER',
                            {
                                onclick: function () {
                                    window.open("/job_order_user/" + e.jo.id + "/details");
                                },
                                timeOut: 0
                            })
                    }
                }
                if (this.my_id.dept_id == 1) {
                    if (e.jo.status == 2) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: 'A New Job Order Request has been approved! ' +
                                ' Click for more details',
                            icon: '/assets/img/5167-shake-hands2.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/job_order_admin/" + e.jo.id + "/details");
                                this.close();
                            }
                        });
                        toastr.warning(' Request Approved!',
                            'JOB ORDER',
                            {
                                onclick: function () {
                                    window.open("/job_order_admin/" + e.jo.id + "/details");
                                },
                                timeOut: 0
                            })
                    }
                }
            });
        // Superior JO Notification
        Echo.channel('managerchannel')
            .listen('SuperiorJOSent', (e) => {
                if (this.my_id.id == e.user.superior) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Job Order Request was sent! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/sup_jo_request/" + e.jo.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'JOB ORDER REQUEST',
                        {
                            onclick: function () {
                                window.open("/sup_jo_request/" + e.jo.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Dept Head JO Notification
        Echo.channel('managerchannel')
            .listen('DeptHeadJOSent', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Job Order Request was sent! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/mng_jo_req/" + e.jo.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'OBP REQUEST',
                        {
                            onclick: function () {
                                window.open("/mng_jo_req/" + e.jo.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // supperior notif
        Echo.channel('adminchannel')
            .listen('SupplyRequestSend', (e) => {
                if (this.my_id.id == e.user.superior) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Supplies Request was sent! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/supplies_request_manager/" + e.supp.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Supplies REQUEST',
                        {
                            onclick: function () {
                                window.open("/supplies_request_manager/" + e.supp.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // dept head notif
        Echo.channel('adminchannel')
            .listen('SupplyRequestSendtoHead', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Supplies Request was sent! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/supplies_request_head/" + e.supp.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A New Request was sent!',
                        'Supplies REQUEST',
                        {
                            onclick: function () {
                                window.open("/supplies_request_head/" + e.supp.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // user notif
        Echo.channel('adminchannel')
            .listen('ApproveByAdminDept', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/definite.mp3");
                    Push.create("HEY! ", {
                        body: ' Your Supplies Request was approved by the Admin Department! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/supplies_request/" + e.supp.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' Your Request was approved!',
                        'Supplies REQUEST',
                        {
                            onclick: function () {
                                window.open("/supplies_request/" + e.supp.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // admin/user notif
        Echo.channel('adminchannel')
            .listen('SendToAdminDept', (e) => {
                if (e.supp.manager_action == 1) {
                    if (this.my_id.id == e.user.id) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: ' Your request was approved and will be moved to the admin department! Click for more details',
                            icon: '/assets/img/24048-paper-clip-outline5.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/supplies_request/" + e.supp.id + "/details");
                                this.close();
                            }
                        });
                        toastr.warning(' Your request was approved!',
                            'Supplies REQUEST',
                            {
                                onclick: function () {
                                    window.open("/supplies_request/" + e.supp.id + "/details");
                                },
                                timeOut: 0
                            })
                    }
                    if (this.my_id.dept_id == 1) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: ' A new Supplies Request was sent! Click for more details',
                            icon: '/assets/img/24048-paper-clip-outline5.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/supplies_request_admin/" + e.supp.id + "/details");
                                this.close();
                            }
                        });
                        toastr.warning(' A New Request was sent!',
                            'Supplies REQUEST',
                            {
                                onclick: function () {
                                    window.open("/supplies_request_admin/" + e.supp.id + "/details");
                                },
                                timeOut: 0
                            })
                    }
                }
                if (e.supp.manager_action == 2) {
                    if (this.my_id.id == e.user.id) {
                        $.playSound("/assets/definite.mp3");
                        Push.create("HEY! ", {
                            body: ' Your request was denied! Click for more details',
                            icon: '/assets/img/24048-paper-clip-outline5.png',
                            timeout: 0,
                            onClick: function () {
                                window.open("/supplies_request/" + e.supp.id + "/details");
                                this.close();
                            }
                        });
                        toastr.warning(' Your request was denied!',
                            'Supplies REQUEST',
                            {
                                onclick: function () {
                                    window.open("/supplies_request/" + e.supp.id + "/details");
                                },
                                timeOut: 0
                            })
                    }
                }
            });
        // Announcement Notification
        Echo.channel('announcementchannel')
            .listen('AnnouncementPosted', (e) => {
                if (this.my_id.dept_id == e.dept) {
                    $.playSound("/assets/quite-impressed.mp3");
                    toastr.info(' Hey! there is a new announcement, click for more details',
                        e.ann.subject,
                        {
                            onclick: function () {
                                window.open("/memo/" + e.ann.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });

        // Gatepass Return to admin issue by Notification
        Echo.channel('adminchannel')
            .listen('GatePassForClosing', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/quite-impressed.mp3");
                    Push.create("HEY! ", {
                        body: ' A Gatepass request is waiting to be closed! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/gatepassadmin/" + e.gatepass.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A Gatepass request is waiting to be closed!',
                        'Gatepass REQUEST',
                        {
                            onclick: function () {
                                window.open("/gatepassadmin/" + e.gatepass.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });

        // Gatepass User Notification
        Echo.channel('adminchannel')
            .listen('GatePassApproved', (e) => {
                if (this.my_id.id == e.gatepass.user_id) {
                    $.playSound("/assets/quite-impressed.mp3");
                    Push.create("HEY! ", {
                        body: ' Your Gatepass request was updated! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/gatepass/" + e.gatepass.id);
                            this.close();
                        }
                    });
                    toastr.warning(' Your Gatepass request was updated!',
                        'Gatepass REQUEST',
                        {
                            onclick: function () {
                                window.open("/gatepass/" + e.gatepass.id);
                            },
                            timeOut: 0
                        })
                }
            });

        // Gatepass New Notification
        Echo.channel('adminchannel')
            .listen('NewGatePass', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/quite-impressed.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Gatepass Request was sent! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/gatepassadmin/" + e.gatepass.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A new Gatepass Request was sent! Click for more details!',
                        'Gatepass REQUEST',
                        {
                            onclick: function () {
                                window.open("/gatepassadmin/" + e.gatepass.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });

        // Gatepass Move to Manager Notification
        Echo.channel('adminchannel')
            .listen('GatePassMoveToManager', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/quite-impressed.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Gatepass Request was sent! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/gatepassadminmanager/" + e.gatepass.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A new Gatepass Request was sent! Click for more details!',
                        'Gatepass REQUEST',
                        {
                            onclick: function () {
                                window.open("/gatepassadminmanager/" + e.gatepass.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });

        // Gatepass Move to Guard Notification
        Echo.channel('adminchannel')
            .listen('GatePassMoveToGuard', (e) => {
                if (this.my_id.id == e.user.id) {
                    $.playSound("/assets/quite-impressed.mp3");
                    Push.create("HEY! ", {
                        body: ' A new Gatepass Request was sent! Click for more details',
                        icon: '/assets/img/24048-paper-clip-outline5.png',
                        timeout: 0,
                        onClick: function () {
                            window.open("/guardgatepass/" + e.gatepass.id + "/details");
                            this.close();
                        }
                    });
                    toastr.warning(' A new Gatepass Request was sent! Click for more details!',
                        'Gatepass REQUEST',
                        {
                            onclick: function () {
                                window.open("/guardgatepass/" + e.gatepass.id + "/details");
                            },
                            timeOut: 0
                        })
                }
            });
        // Admin notify expired
        // Echo.channel('adminchannel')
        //     .listen('ExpiredAssetSent', (e) => {
        //         if(this.my_id.dept_id == 1){
        //             $.playSound("/assets/19475726_notification-bell-sound_by_eskoma_preview.mp3");
        //             Push.create("HEY! Admin " , {
        //                 body: e.ass +' Assets must be returned today! Click to view assets list',
        //                 icon: '/assets/img/1110-exclamation-mark-in-a-circle2.png',
        //                 timeout: 10000,
        //                 onClick: function () {
        //                     window.open("/asset_trackings");
        //                     this.close();
        //                 }
        //             });
        //         }
        //     });
    },

    methods: {
        fetchMessages(to_id) {
            this.ids = [to_id, this.my_id.id];
            this.to_id = to_id;
            axios.get('/fetch_messages', { params: { to_id: to_id } }).then(response => {
                this.messages = response.data.messages;
                this.to_user = response.data.to_user;
                this.to_group = ''
            }).catch((error) => {
                console.log('error')
                swal("Whoops!", "Kindly Refresh the Page!", "warning");
            });
            this.getChatFiles(to_id)
            this.messageSeen(to_id)
        },
        addMessage(message) {
            this.messages.push(message);
            axios.post('/messages', message)
                .then(response => {
                }).catch((error) => {
                    console.log('error')
                    swal("Whoops!", "Error in Sending Chat, Kindly Refresh the page!", "warning");
                });
        },
        getAllOnlineUser() {
            axios.get('/online_user').then(response => {
                this.onlines = response.data.users;
                if (response.data.messages != null) {
                    this.unseen = response.data.messages;
                    this.unseencount = response.data.unseencount;
                }
            });
        },
        getMySession() {
            axios.get('/my_session').then(response => {
                this.my_id = response.data;
                this.ids = [this.to_id, this.my_id.id];
            });
        },
        removeUserOnline: function (user) {
            for (var i = 0; i < this.onlines.length; i++) {
                if (this.onlines[i].id == user.user.id) {
                    this.onlines.splice(i, 1);
                }
            }
        },
        messageSeen(to_id) {
            this.to_id = to_id;
            axios.get('/seen_message', { params: { to_id: to_id } }).then(response => {
            });
            this.getAllOnlineUser()
        },
        getChatFiles(to_id) {
            this.to_id = [to_id]
            axios.get('/getchatfiles', { params: { to_id: to_id } }).then(response => {
                this.sfiles = response.data.files
                this.sfcount = response.data.files_count
            });
        },
        chatSendFile(fd) {
            axios.post('/chatuploadfile', fd).then(response => {
                swal("Good job!", "File Successfuly Uploaded!", "success");
                // this.fetchMessages(response.data.to_id)
                this.getChatFiles(response.data.to_id)
                window.location.reload();
            }).catch((error) => {
                console.log('error')
                swal("Whoops!", "Error in Uploading file, Kindly refresh the page!", "warning");
            });
        },
        chatDownloadFile(id) {
            swal("Yes!", "File was downloaded!", "success");
            window.open("/downloadchatfile/" + id + "/now");
        },
        chatFileSearch(search, to_user, from_user) {
            axios.post('/chatfilesearch', { search, to_user, from_user }).then(response => {
                this.sfiles = response.data.files
            });
        },
        //group message functions
        fetchGroupMessages(group_id) {
            this.group_id = [group_id]
            axios.get('/getgroupmessage', { params: { group_id: group_id } }).then(response => {
                this.gmessages = response.data.gmessages
                this.to_group = response.data.group_name
                this.to_user = ''
            }).catch((error) => {
                console.log('error')
                swal("Whoops!", "Kindly Refresh the Page!", "warning");
            });
            this.getGroupFiles(group_id)
            this.seenGroupMessage(group_id)
        },
        seenGroupMessage(group_id) {
            this.group_id = [group_id]
            axios.get('/seengroupmessage', { params: { group_id: group_id } }).then(response => {
            });
            this.getAllGroup()
        },
        sendFile(fd) {
            axios.post('/uploadfile', fd).then(response => {
                swal("Good job!", "File Successfuly Uploaded!", "success");
                this.getGroupFiles(response.data.group_id)
                window.location.reload();
            }).catch((error) => {
                console.log('error')
                swal("Whoops!", "Error in Uploading file, Kindly refresh the page!", "warning");
            });
        },
        getGroupFiles(group_id) {
            this.group_id = [group_id]
            axios.get('/getgroupfiles', { params: { group_id: group_id } }).then(response => {
                this.files = response.data.files
                this.fcount = response.data.files_count
            });
        },
        downloadFile(id) {
            swal("Yes!", "File was downloaded!", "success");
            window.open("/downloadgroupfile/" + id + "/now");
        },
        fileSearch(search, group_id) {
            axios.post('/filesearch', { search, group_id }).then(response => {
                this.files = response.data.files
            });
        },
        sendGroupMessage(gmessage, group_id) {
            this.gmessages.push(gmessage)
            axios.post('/sendgroupmessage', gmessage).then(response => {
            }).catch((error) => {
                console.log('error')
                swal("Whoops!", "Error in Sending Group chat, Kindly Refresh page!", "warning");
            });
        },
        createGroup1(group_name) {
            // this.groups.push(group_name)
            axios.post('/groupadd', group_name).then(response => {
                this.getAllGroup()
            }).catch((error) => {
                console.log('error')
                swal("Whoops!", "Error in Creating Group, Kindly Refresh the Page!", "warning");
            });
        },
        getAllGroup() {
            axios.get('/showgroups').then(response => {
                this.groups = response.data.groups
                if (response.data.unseen != null) {
                    this.gunseen = response.data.unseen
                    this.gunseencount = response.data.gunseencount
                }
            });
        },
        getGroupMembers(group_id) {
            this.group_id = [group_id]
            axios.get('/getgroupmembers', { params: { group_id: group_id } }).then(response => {
                this.members = response.data.users
                this.group = response.data.group
            });
        },
        getNonMembers(group_id) {
            this.group_id = [group_id]
            axios.get('/getnonmembers', { params: { group_id: group_id } }).then(response => {
                this.nonmembs = response.data.users
            });
        },
        searchNonMember(search, group_id) {
            axios.post('/searchnonmember', { search, group_id }).then(response => {
                this.nonmembs = response.data.users
            });
        },
        searchMember(search, group_id) {
            axios.post('/searchmember', { search, group_id }).then(response => {
                this.members = response.data.users
            });
        },
        removeGroupMember(user_id, group_id) {
            this.members = user_id
            this.group_id = group_id
            axios.get('/removegroupmember', { params: { group_id: group_id, members: this.members } }).then(response => {
            }).catch((error) => {
                console.log('error')
                swal("Whoops!", "Error in Removing member from Group, Kindly Refresh page!", "warning");
            });
        },
        addGroupMembers(user_id, group_id) {
            axios.post('/addgroupmembers', { user_id, group_id }).then(response => {
            }).catch((error) => {
                console.log('error')
                swal("Whoops!", "Error in adding of Group member(s), Kindly refresh the page!", "warning");
            });
        },
        // dashboard functions
        hrdashboard() {
            axios.get('/hrdashboard').then(response => {
                this.totalworkauth = response.data.totalworkauth
                this.totalobp = response.data.totalobp
                this.totalundertime = response.data.totalundertime
                this.totalrequisition = response.data.totalrequisition
                this.workauth_p = response.data.workauthP
                this.obp_p = response.data.obpP
                this.undertime_p = response.data.undertimeP
                this.requisition_p = response.data.requisitionP
                this.pendingobps = response.data.pendingobps
                this.workauths = response.data.workauths
                this.undertimes = response.data.undertimes
                this.reqs = response.data.reqs
                this.exitpass_p = response.data.exitpassP
                this.exitpass = response.data.exitpass
                this.emp_req_p = response.data.empreqP
                this.emp_reqs = response.data.empreqs
            });
        },
        itdashboard() {
            axios.get('/itdashboard').then(response => {
                this.totals_pending = response.data.totalSPending
                this.totals_returned = response.data.totalSReturned
                this.totals_solved = response.data.totalSSolved
                this.totalu_pending = response.data.totalUPending
                this.totalu_returned = response.data.totalUReturned
                this.totalu_solved = response.data.totalUSolved
                this.total_it_pending = response.data.totalITpending
                this.total_it_returned = response.data.totalITreturned
                this.total_it_solved = response.data.totalITsolved
                this.solved_service = response.data.solvedService
                this.solved_access = response.data.solvedAccess
                this.totals_pending1 = response.data.totalSPending1
                this.totals_returned1 = response.data.totalSReturned1
                this.totals_solved1 = response.data.totalSSolved1
                this.totalu_pending1 = response.data.totalUPending1
                this.totalu_returned1 = response.data.totalUReturned1
                this.totalu_solved1 = response.data.totalUSolved1
                this.total_it_pending1 = response.data.totalITpending1
                this.total_it_returned1 = response.data.totalITreturned1
                this.total_it_solved1 = response.data.totalITsolved1
                this.solved_service1 = response.data.solvedService1
                this.solved_access1 = response.data.solvedAccess1
                this.its = response.data.its
                this.itscount = response.data.itscount
            });
        },
        asdashboard() {
            axios.get('/asdashboard').then(response => {
                this.assetp = response.data.assetP
                this.jop = response.data.joP
                this.totalasset = response.data.totalasset
                this.totaljo = response.data.totaljo
                this.assetpending = response.data.assetpending
                this.assetrp = response.data.assetrp
                this.totalassetrp = response.data.totalassetrp
            });
        },
        userSearch(search) {
            axios.post('/search_user', { search }).then(response => {
                this.onlines = response.data
            });
        },
        expireAsset() {
            axios.get('/assetexpire').then(response => {
            });
        },
        groupSearch(search) {
            axios.post('/search_group', { search }).then(response => {
                this.groups = response.data
            });
        },
        // maam tiffany routes
        mtdashboard() {
            axios.get('/mtdashboard').then(response => {
                this.mtog = response.data.mtuseraccs
                this.saps = response.data.saps
            });
        },
        mydashboard() {
            axios.get('/mydashboard').then(response => {
                this.myworks = response.data.myworks
                this.myunds = response.data.myunds
                this.myitems = response.data.myitems
                this.myobps = response.data.myobps
                this.myreqs = response.data.myreqs
                this.myits = response.data.myits
                this.mysum = response.data.mysum
            });
        }
    }
});
