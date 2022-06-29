<template>
     <div class="container mt-3">
        <h1 class="b-title c-title">Contact Us</h1>
        <div class="contact-container ">
             <form  >
                   <div class="input-group mb-3">
                        <input type="text" v-model="name" placeholder="Enter your name please" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email"  v-model="email" placeholder="Enter your email please" required />
                    </div>

                    <div class="input-group mb-3">
                       <textarea v-model="message"   placeholder="Your Message" rows="10"></textarea>
                    </div>
                    <div class="buttons-group">
                        <button  type="button" @click="sendEmail"><i class="ri-send-plane-fill"></i> Send</button>

                    </div>

             </form>

        </div>

    </div>
</template>


<script>
import emailjs from 'emailjs-com';
import Swal from 'sweetalert2/dist/sweetalert2.all.min.js'
// import 'sweetalert2/src/sweetalert2.scss';
import ScrollReveal from 'scrollreveal'
export default {
    mounted() {
        this.scrollAnimation();
    },
  methods: {
       sendEmail() {
        try {
            if(this.name !== '' && this.email !== '' ){
                emailjs.send("service_w29t9ub","template_vigy969",{
                        name: this.name,
                        email: this.email,
                        message: this.message
                        },'7AJ-7GNapYb4fKyty');
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Message sent, please wait for a response.',
                    showConfirmButton: true,
                    timer: 1500
                    })
            }else{

                    Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Please enter personal data in the fields.',
                    showConfirmButton: true,
                    timer: 1500
                    })
            }

        } catch(error) {
            console.log({error})
        }
        // Reset form field
        this.name = ''
        this.email = ''
        this.message = ''
        },
         scrollAnimation(){
            const sr = ScrollReveal({
                origin: 'top',
                distance: '260px',
                duration: 2500,
                delay: 200,
            })
            sr.reveal(`.c-title`, {delay:1000})
            sr.reveal(`.contact-container`, {delay:1200})
          }
  },
  data () {
    return {
        name:'',
        email:'',
        message:'',
    }
  },
    name :'contact',
}
</script>


<style>
@import url('https://fonts.googleapis.com/css2?family=Oswald:wght@600&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');


/*======================== VARIABLES CSS =========================*/
:root {

    --my-main-color:#875FCD;
    --my-second-color: #E3E3E3;
    --body-font : 'Poppins', sans-serif;
    --body-color: #FAFAFA;
    --main-color: #F4EAFA;
    --title-color:#393939;
    --text-color:#8E8E8E;
    --h2-font-size: 1.25rem;
    --h3-font-size: 1rem;
    --normal-font-size: .938rem;
    --small-font-size: .813rem;
    --smaller-font-size: .75rem;


    /** dark mode variable **/
    --body-color-dark:#0E0E0E;
     --text-color-dark:#F1F1F1;
     --text-seconde-color-dark: #E3E3E3;
}

/* ============ contact in darak mode ============ */
         body.dark-theme   .input-group input::-webkit-input-placeholder,body.dark-theme textarea::-webkit-input-placeholder {
             color: white;

         }
        body.dark-theme .input-group input, body.dark-theme textarea, body.dark-theme .buttons-group .button_socail{
        background-color: #2B2B2B;
        color: var(--main-color);
        }

    body.dark-theme.buttons-group button{
    background: var(--dark-pr-color);
    }
    body.dark-theme .buttons-group button:hover{
        background:#202020;
    }

/*    =================== end dark mode style ============= */

/* ========================= Contact componenet style =======================  */

.contact-container form {
    width: 100%;
}
.input-group input  {
    width: 100%;
    border: none;
    padding: 20px;
    outline: none;
    border-radius: 2rem;
    height: 2rem;
    background-color: var(--my-second-color);
}


.input-group textarea {
    width: 100%;
    border: none;
    outline: none;
    padding: 20px;
    border-radius: 2rem;
    resize: none;
    background-color: var(--my-second-color);
}
.buttons-group{
    display: flex;
    justify-content: flex-start;
    align-items: center;
    column-gap: .5rem;
}
.buttons-group button{
    padding: 10px 34px;
    border: none;
    border-radius: 0.5rem;
    background: #495182;
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
}

.buttons-group button:hover{

    background: var(--my-sc-color);

}

/* ========================= Contact componenet style =======================  */
</style>
