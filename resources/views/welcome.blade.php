<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forms</title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">

        .dd-dn {
            display: none;
        }

    </style>

    <!-- Somente para exemplo -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.0/ladda.min.css">
</head>
<body>

<div class="container-fluid">
    <div class="page-header">
        <h1>Formulário <small>Newsletter</small></h1>
    </div>
    <form method="post" action="/contact">
        {{ csrf_field() }}
        <div class="alert alert-success dd-dn" role="alert"></div>
        <div class="alert alert-danger dd-dn" role="alert"></div>
        <div class="form-group">
            <label for="exampleInputName1">Name</label>
            <input name="name" type="text" class="form-control" id="exampleInputName1" placeholder="Name">
            <span class="help-block dd-dn"></span>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="email" type="text" class="form-control" id="exampleInputEmail1" placeholder="Email">
            <span class="help-block dd-dn"></span>
        </div>
        <div class="checkbox">
            <label>
                <input name="error" type="checkbox" value="1"> Error
            </label>
            <label>
                <input name="redirect" type="checkbox" value="1"> Redirect
            </label>
        </div>
        <button id="newsletter-btn" type="submit" class="ladda-button" data-style="expand-right"><span class="ladda-label">Submit</span></button>
    </form>
</div>


<div class="container-fluid">
    <div class="page-header">
        <h1>Formulário <small>Contato</small></h1>
    </div>
    <form method="post" action="/contact">
        {{ csrf_field() }}
        <div class="alert alert-success dd-dn" role="alert"></div>
        <div class="alert alert-danger dd-dn" role="alert"></div>
        <div class="form-group">
            <label for="exampleInputName2">Name</label>
            <input name="name" type="text" class="form-control" id="exampleInputName2" placeholder="Name">
            <span class="help-block dd-dn"></span>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail2">Email address</label>
            <input name="email" type="text" class="form-control" id="exampleInputEmail2" placeholder="Email">
            <span class="help-block dd-dn"></span>
        </div>
        <div class="checkbox">
            <label>
                <input name="error" type="checkbox" value="1"> Error
            </label>
            <label>
                <input name="redirect" type="checkbox" value="1"> Redirect
            </label>
        </div>
        <button id="contact-btn" type="submit" class="ladda-button" data-style="expand-right"><span class="ladda-label">Submit</span></button>
    </form>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="//oss.maxcdn.com/jquery.form/3.50/jquery.form.min.js"></script>

<!-- Somente para exemplo -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.0/spin.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.0/ladda.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.0/ladda.jquery.min.js"></script>

<script>
    $( document ).ready(function() {

        $('#newsletter-btn').ladda();
        $('#contact-btn').ladda();

        $('form').ajaxForm({
            dataType: 'json',
            resetForm: true,
            beforeSubmit: function(data, $form) {
                $form.find('.alert').html('').addClass('dd-dn');
                $form.find('.help-block').html('').addClass('dd-dn');
                $form.find('.form-group').removeClass('has-error');
                $form.find('button').ladda( 'start' );
            },
            success: function(responseJSON, statusText, data, xhr) {

                xhr.find('button').ladda( 'stop' );

                if (responseJSON.status) {

                    if (responseJSON.data.redirect) {
                        window.location.href = responseJSON.data.redirect;
                    } else {
                        xhr.find('.alert.alert-success').html(responseJSON.data.message).fadeIn();
                    }

                } else {
                    xhr.find('.alert.alert-danger').html(responseJSON.data.message).fadeIn();
                }

            },
            error: function(data, responseText, statusText, xhr) {

                xhr.find('button').ladda( 'stop' );

                if (data.status == 422) {

                    var fields = data.responseJSON;

                    $.each(fields, function( index, value ) {
                        var field = xhr.find('[name="'+index+'"]');
                        field.parent('div').addClass('has-error');
                        field.next().removeClass('dd-dn').html(value);
                    });

                } else {
                    xhr.find('.alert.alert-danger').html(responseText).fadeIn();
                }

            }
        });
    });
</script>

</body>
</html>