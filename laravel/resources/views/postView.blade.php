@extends('layouts.blog')

@section("titulo-pagina")
    {{$post->titulo}}
@endsection

@section("subtitulo-pagina")
{{$post->sub_titulo}}
@endsection

@section("imagen"){{ asset("storage/".$post->portada) }}@endsection

@section("content")
<article class="mb-4">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                {!!$post->contenido!!}
            </div>
            <div class="col-md-10 col-lg-8 col-xl-7" >
                <div id="commentContainer">
                <h2>¿Te ha gustado el post? Dejanos tu comentario</h2>
                @foreach ($post->comments as $c)
                    <div class="comment my-1">
                        <div class="col-4 p-4">
                            <img src="{{asset('assets/img/desconocido.png')}}" class="img-fluid" alt="">
                        </div>
                        <div class="col-8 d-flex flex-column py-4">
                            <p >{{$c->nombre}}</p>
                            <p >{{$c->email}}</p>
                            <p class="mt-2 des" >{{$c->comentario}}</p>
                            <p class="mt-auto">El día {{$c->created_at}} </p>
                        </div>

                    </div>

                @endforeach
            </div>
                <div class="my-5">
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- * * SB Forms Contact Form * *-->
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- This form is pre-integrated with SB Forms.-->
                    <!-- To make this form functional, sign up at-->
                    <!-- https://startbootstrap.com/solution/contact-forms-->
                    <!-- to get an API token!-->
                    <form id="contactForm" data-sb-form-api-token="API_TOKEN">
                        <input type="hidden" name="id" value="{{$post->id}}">
                        <div class="form-floating">
                            <input class="form-control" id="name" name="nombre" type="text" placeholder="Enter your name..." data-sb-validations="required" />
                            <label for="name">Nombre</label>
                            <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                        </div>
                        <div class="form-floating">
                            <input class="form-control" id="email" type="email" name="email" placeholder="Enter your email..." data-sb-validations="required,email" />
                            <label for="email">Email</label>
                            <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                            <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" id="message" name="comentario" placeholder="Enter your message here..." style="height: 12rem" data-sb-validations="required"></textarea>
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
                                <div class="fw-bolder">Form submission successful!</div>
                                To activate this form, sign up at
                                <br />
                                <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
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
    </div>


</article>

<style>
    .comment{
        display: flex;
    }
    .comment p{
       margin: 0px;
       font-size: 16px

    }
     .des{
       font-size: 14px
    }
</style>


@endsection

@section("scripts")
<script type="text/javascript">
    const mainData = {{ Js::from($post)}}
    const mainRecursos = {{ Js::from($recursos)}}
    document.querySelectorAll(".container img").forEach((e,i)=>{
        e.classList.add("img-fluid")
        e.style.width="auto"
    })
    $("#contactForm").submit(function (e) {
        e.preventDefault();
        let data = new FormData(document.getElementById("contactForm"))
        axios.post("/comment",data).then((e)=>{
            let c= e.data.data;
            ht=`<div class="comment my-1">
                        <div class="col-4 p-4">
                            <img src="{{asset('assets/img/desconocido.png')}}" class="img-fluid" alt="">
                        </div>
                        <div class="col-8 d-flex flex-column py-4">
                            <p >${c.nombre}</p>
                            <p >${c.email}</p>
                            <p class="mt-2 des" >${c.comentario}</p>
                            <p class="mt-auto">El día ${c.created_at} </p>
                        </div>

                    </div>`
                $("#commentContainer").append(ht);
            $("#contactForm").trigger("reset");
        }).catch((e)=>{
            console.log(e)
        })
    });
</script>
@endsection

