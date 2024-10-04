@extends('layouts.blog')

@section("titulo-pagina")
   {{$setting->titulo}}
@endsection

@section("subtitulo-pagina")
    {{$setting->subtitulo}}
@endsection

@section("imagen"){{ asset('assets/img/post-bg.jpg') }}@endsection

@section("content")

<div class="row gx-4 gx-lg-5 justify-content-center">
    <div class="col-md-10 col-lg-8 col-xl-7">
        @if ($setting->contenido!="" &&$setting->contenido!=null)
        <p>{{$setting->contenido}}</p>
         @endif
    <div class="my-5">
            <!-- * * * * * * * * * * * * * * *-->
            <!-- * * SB Forms Contact Form * *-->
            <!-- * * * * * * * * * * * * * * *-->
            <!-- This form is pre-integrated with SB Forms.-->
            <!-- To make this form functional, sign up at-->
            <!-- https://startbootstrap.com/solution/contact-forms-->
            <!-- to get an API token!-->
            <form id="contactForm" data-sb-form-api-token="API_TOKEN" action="" method="POST">
                <div class="form-floating">
                    <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Enter your name..." data-sb-validations="required"  required/>
                    <label for="name">Name</label>
                    <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                </div>
                <div class="form-floating">
                    <input class="form-control" id="email" name="email" type="email" placeholder="Enter your email..." data-sb-validations="required,email" required/>
                    <label for="email">Email address</label>
                    <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                    <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                </div>
                <div class="form-floating">
                    <input class="form-control" id="telefono" name="telefono" type="tel" placeholder="Enter your phone number..." data-sb-validations="required" required/>
                    <label for="phone">Phone Number</label>
                    <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is required.</div>
                </div>
                <div class="form-floating">
                    <textarea class="form-control" id="contenido" name="contenido" placeholder="Enter your message here..." style="height: 12rem" data-sb-validations="required" required></textarea>
                    <label for="message">Message</label>
                    <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
                </div>
                <br />
                <!-- Submit success message-->
                <!---->
                <!-- This is what your users will see when the form-->
                <!-- has successfully submitted-->
                <div class="d-none" id="submitSuccessMessage">
                    <div class="text-center mb-3">
                        <div class="fw-bolder">Hemos recibido tu mensaje pronto estaremos en contacto contigo</div>
                       </div>
                </div>
                <!-- Submit error message-->
                <!---->
                <!-- This is what your users will see when there is-->
                <!-- an error submitting the form-->
                <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                <!-- Submit Button-->
                <button class="btn btn-primary text-uppercase" id="submitButton" type="submit">Send</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section("scripts")
{{-- <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script> --}}
<script>
    $("#contactForm").submit(function (e) {
        e.preventDefault();
        const data = new FormData(document.getElementById("contactForm"));
        axios.post("",data).then((e)=>{$("#contactForm").trigger("reset");
        $("#submitSuccessMessage").removeClass("d-none")
    }).catch((e)=>{console.log(e)})
    });
</script>
@endsection
