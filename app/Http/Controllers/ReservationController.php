<?php

namespace App\Http\Controllers;

use App\Models\Classroom_type;
use App\Models\File;
use App\Models\Reservation;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class ReservationController extends Controller
{
    var $resourceCookie;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $resource_id = $request->_resource;
        $message = "";
        return view('GeneralViews.Reserves.create', compact('resource_id', 'message'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$user = User::find($request->user_id);
        $user = Auth::user();
        $resource = Resource::find($request->resource_id);
        $end_time = date('Y-m-d H:i:s', strtotime($request->end_time));
            //$request->end_time;
            /**strtotime($request->end_date . " " . $request->end_time);*/;
        $start_time = date('Y-m-d H:i:s', strtotime($request->start_time));;
            //$request->start_time;
            /**strtotime($request->start_date . " " . $request->start_time);*/;
            $message = $this->canReserve($user, $resource, strtotime($start_time), strtotime($end_time));
        if ($message == "") {
            Reservation::create([
                'state' => 'ACTIVE',
                'start_time' => date('Y-m-d H:i:s', strtotime($request->start_time)),
                'end_time' => date('Y-m-d H:i:s', strtotime($request->end_time)),
                'user_id' => $user->id,
                'resource_id' => $resource->id,
                'moulted' => '0'
            ]);
            $sT = date('l jS \of F Y h:i:s A', strtotime($start_time));
            $eT = date('l jS \of F Y h:i:s A', strtotime($end_time));
            $message .= "Reserva exitosa";
            $email = [
                'nameUser' => $user->name,
                'emailUser' => $user->email,
                'message' => $message,
                'resourceId' => $resource->id,
                'resourceName' => $resource->name,
                'startTime' => $sT,
                'endTime' => $eT,
                'resource_tipo' => $resource->type,
            ];
            $this->sendConfirmEmail($email);
        } else {
            $start_time . date('l jS \of F Y h:i:s A');
            $end_time . date('l jS \of F Y h:i:s A');
            $email = [
                'nameUser' => $user->name,
                'emailUser' => $user->email,
                'message' => $message,
                'resourceId' => $resource->id,
                'resourceName' => $resource->name,
                'resource_tipo' => $resource->type,
                'startTime' => $start_time,
                'endTime' => $end_time
            ];
            $this->sendErrorEmail($email);
        }

        $resource_id = $resource->id;
        return view('GeneralViews.Reserves.create', compact('resource_id', 'message','start_time','end_time'));
    }

    /**
     * Send a confirm e-mail to the user.
     *
     * @email -> important info
     */
    public function sendConfirmEmail($email)
    {
        Mail::send('mails.successMail', ['body' => $email], function ($message) use ($email) {
            $message->to($email['emailUser'], $email['nameUser'])
                ->subject('Reserva creada exitosamente.');
            $message->from('siemHellsoft2018@gmail.com', 'SIEM');
        });
    }

    /**
     * Send an e-mail reminder to the user.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function sendErrorEmail($email)
    {
        Mail::send('mails.errorMail', ['body' => $email], function ($message) use ($email) {
            $message->to($email['emailUser'], $email['nameUser'])
                ->subject('Reserva fallida.');
            $message->from('siemHellsoft2018@gmail.com', 'SIEM');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }

    /**
     * Verifica si se puede realizar una reserva
     *
     * @param
     * @return
     */
    private function canReserve($user, $resource, $start_time, $end_time)
    {
        $max_hours = 0;
        $min_hours = 1;
        $hours = ($end_time - $start_time) / 3600;
        $anteriority = ($start_time - time()) / 60;
        $error_message = "";

        if ($resource->type == 'CLASSROOM') {
            if ($user->type == 'STUDENT') {
                $max_hours = 2;
            } else {
                $max_hours = 4;
            }
        } else if ($resource->type == 'INSTRUMENT') {
            $min_hours = 24;
            $max_hours = 168;
        }
        date_default_timezone_set('America/Bogota');
        if ($anteriority < 0) {
            $error_message .= " - Fecha en el pasado - ";
        }
        if ($hours < 0) {
            $error_message .= " - Fechas inconsistentes - ";
        }
        if (is_int($hours) && $hours >= $min_hours && $hours <= $max_hours) {
            if ($resource->type == 'CLASSROOM') {
                if ($anteriority >= 30 && $anteriority <= 10080) {
                    //
                } else {
                    $error_message .= " - No se encuentra en un tiempo valido - ";
                }
            } else if ($resource->type == 'INSTRUMENT') {
                if ($anteriority >= 120 && $anteriority <= 10080) {
                    //
                } else {
                    $error_message .= " - No se encuentra en un tiempo valido - ";
                }
            }
        } else {
            $error_message .= " - Bloque incorrecto - ";
        }

        if ($user->hasPenalties()) {
            $error_message .= " - El usuario tiene multas - ";
        }
        //dd($resource);
        if (!$resource->isAvailableBetween(date('Y-m-d H:i:s', $start_time), date('Y-m-d H:i:s', $end_time))) {
            $error_message .= " - No está disponible - ";
        }
        return $error_message;
    }

    /**-------------------------------------------------------------------------**/
    public function activeReservations()
    {
        $user_id = Auth::user()->id;
        $reservations = [];
        $userItems = Reservation::where('user_id', $user_id)->where('state', 'ACTIVE')->get();
        foreach ($userItems as $uItem) {
            $resource = Resource::where('id', $uItem->resource_id)->first();
            $classroom = Classroom_type::where('id', $resource->classroom_type_id)->first();
            $item = [
                "id" => $uItem->id,
                "name" => $resource->name,
                "salon" => $classroom->name,
                "inicio" => $uItem->start_time,
                "fin" => $uItem->end_time
            ];
            array_push($reservations, $item);
        }
        return view('GeneralViews.Reserves.active', ['reservations' => $reservations]);
    }

    public function loadHistoryReservations()
    {
        $user_id = Auth::user()->id;
        $reservations = [];
        $userItems = Reservation::where('user_id', $user_id)
            ->where('state', 'FINALIZED')->get();
        foreach ($userItems as $uItem) {
            $resource = Resource::where('id', $uItem->resource_id)->first();
            $image = File::where('resource_id', $resource->id)->first();
            $classroom = Classroom_type::where('id', $resource->classroom_type_id)->first();
            $item = [
                "imagePath" => $image->path,
                "name" => $resource->name,
                "salon" => $classroom->name,
                "inicio" => $uItem->start_time,
                "fin" => $uItem->end_time
            ];
            array_push($reservations, $item);
        }
        return view('GeneralViews.Reserves.history', ['reservations' => $reservations]);
    }

    public function historyReservations()
    {
        $data = request()->all();
        $starTime = date('Y-m-d',strtotime($data['startTime']));
        $endTime = date('Y-m-d',strtotime($data['endTime']));
        $user_id = Auth::user()->id;
        $reservations = [];
        if (!empty($starTime) and !empty($endTime)) {
            $userItems = Reservation::where('user_id', $user_id)
                ->where('state', '!=', 'ACTIVE')
                ->whereDate('start_time', '>=', $starTime)
                ->whereDate('end_time', '<=', $endTime)->get();
        } else {
            $userItems = Reservation::where('user_id', $user_id)
                ->where('state', '!=', 'ACTIVE')->get();
        }
        foreach ($userItems as $uItem) {
            $resource = Resource::where('id', $uItem->resource_id)->first();
            $image = File::where('resource_id', $resource->id)->first();
            $classroom = Classroom_type::where('id', $resource->classroom_type_id)->first();
            $item = [
                "imagePath" => $image->path,
                "name" => $resource->name,
                "salon" => $classroom->name,
                "inicio" => $resource->start_time,
                "fin" => $resource->end_time
            ];
            array_push($reservations, $item);
        }
        return view('GeneralViews.Reserves.history', ['reservations' => $reservations]);
    }

    public function cancelReservations()
    {
        $data = request()->all();
        $reservas = isset($data['selected']) ? $data['selected'] : array();
        $user_id = Auth::user()->id;
        if (!empty($data['all']) and $data['all'] == true) {
            $userItems = Reservation::where('user_id', $user_id)->get();
            foreach ($userItems as $item) {
                $item->state = 'CANCELED';
                $item->save();
            }
        } else {
            foreach ($reservas as $value) {
                $userItems = Reservation::where('user_id', $user_id)
                    ->where('id', $value)->get();
                foreach ($userItems as $item) {
                    $item->state = 'CANCELED';
                    $item->save();
                }
            }
        }
        return view('GeneralViews.Reserves.active');
    }
}
