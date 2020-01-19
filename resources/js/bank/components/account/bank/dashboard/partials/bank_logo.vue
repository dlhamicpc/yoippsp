<template>
    <!-- Bank Logo=============================== -->
    <div class="bg-light shadow-sm rounded text-center p-3 mb-4">
        <form id="form_change_bank_logo" method="post" @submit.prevent=""></form>
            <div class="profile-thumb mt-3 mb-4"> 
                <img class="rounded-circle" 
                    :src="get_bank_logo()" 
                    height="100"
                    width="100"
                    alt="">
              
                <div class="profile-thumb-edit custom-file bg-primary text-white" 
                    data-toggle="tooltip" 
                    title="Change Bank Logo"> 
                    <i class="fas fa-camera position-absolute"></i>
            
                    <input type="file" class="custom-file-input" id="bank_logo" name="bank_logo" @change="set_bank_logo">

                </div>
            
            </div>

            <p class="text-3 font-weight-500 mb-2">
                {{ userDetails.bank_name }} Bank
            </p>

            <p class="mb-2">

                <router-link to="/bank/profile" 
                    class="text-5 text-light" 
                    data-toggle="tooltip" 
                    title="Edit Profile">
                        <i class="fas fa-edit"></i>
                </router-link>

                <button class="btn btn-primary btn-block"
                            @click="update_bank_logo"
                            :class="{'btn btn-secondary btn-block': isInvalid}"
                            :disabled="isInvalid">
                            Change Bank Logo 
                </button>
            </p>

        </form>
    </div>
    <!-- Bank Logo End -->
</template>

<script>
    export default {
        mounted() {
            
        },

        data(){
            return {
                userDetails: this.userDetails,
                isInvalid: true,

                form_change_bank_logo: new Form({
                    bank_logo: this.userDetails.bank_logo,
                    changed: false,
                    file_type: null,
                    file_size: null,
                })
                ,
                
            }
        },

        methods: {
            full_name() {
                return this.userDetails.admin_name + " " + this.userDetails.admin_father_name; 
            }
            ,

            get_bank_logo(){
                return (this.form_change_bank_logo.bank_logo.length > 100) ? 
                this.form_change_bank_logo.bank_logo:"/storage/uploads/banks_logo/"+this.form_change_bank_logo.bank_logo;
            }
            ,

            set_bank_logo(e){
      
                try {
                    const file = e.target.files[0];
                    if(file != null && this.validate_bank_logo(file)){

                        let reader = new FileReader();
                        reader.onloadend = (file) => {
                            this.form_change_bank_logo.bank_logo = reader.result;
                        }

                        reader.readAsDataURL(file);
                        this.form_change_bank_logo.file_type = file['type']; 
                        this.form_change_bank_logo.file_size = file['size'];
                        this.isInvalid = false;
                        this.form_change_bank_logo.changed = true;             
                    }
                } catch (error) {
                    this.form_change_bank_logo.bank_logo = user.bank_logo;
                    console.log('ALERT ERROR HAPPENED C2' + error.message);
                    some_thing_went_wrong.fire();
                    ECHO.$emit('END_LOADING');
                }
                
                
            }
            ,

            validate_bank_logo(file){
                if( file['type'].search('image') == -1 ){
                    this.form_change_bank_logo.bank_logo = user.bank_logo;
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Unsupported image format!'
                    });
                    return false;
                }
                else if( file['size'] > 5242880 ){
                    this.form_change_bank_logo.bank_logo = user.bank_logo;
                    swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'You are uploading a large file!'
                    });
                    return false;
                }
                return true;
            }
            ,

            update_bank_logo(){
                
              ECHO.$emit('START_LOADING');

                this.form_change_bank_logo.put('api/update_bank_logo/')
                    .then(( response ) => {

                        let data = response.data;

                        if( data == 'unsupported format' ){
                            this.form_change_bank_logo.bank_logo = user.bank_logo;
                            swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Unsupported format!'
                            });
                            
                        }
                        else if( data == 'file size too large' ){
                            this.form_change_bank_logo.bank_logo = user.bank_logo;
                            swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'You are uploading a large file!'
                            });
                        }
                        else if( data == 'failed' ){
                            this.form_change_bank_logo.bank_logo = user.bank_logo;
                            console.log('ALERT ERROR HAPPENED C1' + error.message);
                            some_thing_went_wrong.fire();
                            ECHO.$emit('END_LOADING');
                        }
                        else{
                            toast.fire({
                                type: 'success',
                                title: 'Bank Logo Updated Successfully'
                            });

                            
                            this.isInvalid = true;

                            ECHO.$emit('UPDATE_USER', data);
                            ECHO.$emit('END_LOADING');
                        }
                        
                    })
                    .catch((error) => {
                        this.form_change_bank_logo.bank_logo = user.bank_logo;
                        console.log('ALERT ERROR HAPPENED C2' + error.message);
                        some_thing_went_wrong.fire();
                        ECHO.$emit('END_LOADING');
                    });
            }
            ,

        },

        created(){


            ECHO.$on('UPDATE_USER',(data)=>{
                Vue.prototype.user = data;
            });

        }
        ,

    }
</script>
