<!DOCTYPE html>
<html lang="en">

<head>
    <title>KKO | Szavazás</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://daemonite.github.io/material/css/material.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/css/vote.css')}}">
</head>
<body>
    <div class="container">
        <div class="row">
            <h1>Kar Kiváló Oktatója</h1>
        </div>
        @if ($errors->any())
            <div class="row alert alert-danger">
                <h5 class="text-dark">Helytelen szavazat, kérlek szavazz újra!</h5>
            </div>
        @endif
        <div class="row">
            <form method="POST" action="/vote" id="voteForm">
                @csrf
                @foreach($teachers as $teacher)
                    <label>
                        <input type="checkbox" name="id[]" class="card-input-element d-none" value="{{$teacher->id}}">
                        <div class="wrapper">
                            <div class="card d-flex flex-row justify-content-between non-overlay">
                                <div class="card-body my-card-header">
                                    {{$teacher->name}}
                                </div>
                                <div class="card-body normalize">
                                    {{$teacher->description}}
                                </div>
                            </div>
                            <div class="overlay"></div>
                        </div>
                    </label>
                @endforeach
            </form>
        </div>
        <div class="row">
            <button type="submit" class="btn btn-primary mb-5" form="voteForm" value="Submit">
                Szavazás
            </button>
        </div>
    </div>

    <script src="js/jquery-1.7.2.js"></script>
    <script>
        const priority_to_class = {
            1: 'd-flex first',
            2: 'd-flex second',
            3: 'd-flex third'
        };

        const MAX_PRIORITY = 3;

        let checks = [];

        $(document).ready(function() {
            $("input:checkbox").prop("checked", false);
        });

        function checkLimitReached() {
            return checks.length == MAX_PRIORITY;
        }

        function updateUncheckedBoxes() {
            $("input:checkbox").not(":checked").attr("disabled", checkLimitReached());
        }

        function getOverlayFromInputElement(element) {
            return $(element).siblings(".wrapper").children(".overlay");
        }

        function getCardHeaderFromInputElement(element) {
            return $(element).siblings(".wrapper").children(".card").children(".my-card-header");
        }

        $("input:checkbox").click(function() {
            if (this.checked) {
                if (checkLimitReached()) {
                    // theoretically this should never happen under normal circumstances
                    // but if it does, we undo this dirty action
                    $(this).prop("checked", false);
                } else {
                    checks.push(this);
                    const priority = checks.length; // the updated length represents the new prio
                    $(`<input type="hidden" name="prio[]" value="${priority}">`).insertAfter($(this));
                    getOverlayFromInputElement(this).addClass(priority_to_class[priority]);
                    getOverlayFromInputElement(this).text(`${priority}. ${getCardHeaderFromInputElement(this).text()}`);

                    if (checkLimitReached()) {
                        for (let i = 0; i < checks.length; i++) {
                            getOverlayFromInputElement(checks[i]).addClass("maximum_selection_reached");
                        }
                    }
                }
            } else {
                const index = checks.findIndex((element) => element == this);
                if (index != -1) { // again, it should never be -1
                    // remove element from array of checked boxes
                    checks.splice(index, 1);
                    // remove the corresponding hidden input containing its priority
                    $(this).siblings('[type="hidden"]').remove();

                    // remove the actual DOM element's class selector (overlay)
                    getOverlayFromInputElement(this).removeClass(priority_to_class[index + 1]);
                    // update all subsequent elements' properties (both JS and DOM related)
                    for (let i = index; i < checks.length; i++) {
                        $(checks[i]).siblings('[type="hidden"]').val(parseInt($(checks[i]).siblings('[type="hidden"]').val()) - 1);

                        const previous_priority = i + 2;    // before the deletion zero-indexing + 1
                        const new_priority = i + 1;         // zero-indexing + 1
                        getOverlayFromInputElement(checks[i])
                            .removeClass(priority_to_class[previous_priority])
                            .addClass(priority_to_class[new_priority]);
                        getOverlayFromInputElement(checks[i]).text(`${new_priority}. ${getCardHeaderFromInputElement(checks[i]).text()}`);
                    }

                    if (checks.length == MAX_PRIORITY - 1) {
                        getOverlayFromInputElement(this).removeClass("maximum_selection_reached");
                        for (let i = 0; i < checks.length; i++) {
                            getOverlayFromInputElement(checks[i]).removeClass("maximum_selection_reached");
                        }
                    }
                }
            }

            updateUncheckedBoxes();
        });

    </script>
</body>
</html>
