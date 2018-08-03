<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <table class="table table-striped">
                    <th><strong> Origin </strong></th>
                    <th><strong> Destination </strong></th>
                    <th><strong> Total fare </strong></th>
                        @foreach ($PricedItineraries as $row)
                            <tr>
                                <td>{{$origin}}</td>
                                <td>{{$destination}}</td>                          
                            <td>{{$row->AirItineraryPricingInfo->ItinTotalFare->TotalFare->Amount}} {{$row->AirItineraryPricingInfo->ItinTotalFare->TotalFare->CurrencyCode}}</td>
                            </tr>
                        @endforeach
                    </table>
            </div>
        </div>
    </body>
</html>
