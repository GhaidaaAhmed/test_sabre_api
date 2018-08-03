<h2>Flights Search</h2>
        <div class="row justify-content-md-center">
            <div class="col-md-6">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form  method="post" action="/flights/search" enctype="multipart/form-data">
                {{method_field('POST')}}
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                       <label >From</label>
                        <input type="text" name="origin" class="form-control" placeholder="Enter Origin" required>
                    </div>
                    <div class="col-md-6">
                        <label >Destination</label>
                         <input type="text" name="destination" class="form-control" placeholder="Enter Destination" required>
                     </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                            <label >Depart Date </label>
                            <input type="date" name="departuredate" class="form-control" required/>
                             </div>
                    <div class="col-md-6">
                            <label >Return Date </label>
                            <input type="date" name="returndate" class="form-control" required/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <input type="submit" value="SUBMIT" class="btn btn-primary pl-5 pr-5">
                    </div>
                </div>

            </form>
        </div>
    </div>


