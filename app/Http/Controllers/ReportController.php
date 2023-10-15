<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorereportRequest;
use App\Http\Requests\UpdatereportRequest;
use App\Mail\ReportMail;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Report::select('id','client_id', 'date', 'people', 'hour', 'description', 'refer')->orderBy('date', 'DESC')
        ->where('user_id', auth()->user()->id)->get();
    }


    public function showDate(StorereportRequest $request)
    {
        return Report::select('id','client_id', 'date', 'people', 'hour', 'description', 'refer')->orderBy('date', 'DESC')
        ->where('user_id', auth()->user()->id)
        ->where('date', $request->date)
        ->get();
    }

    public function showClientRep(StorereportRequest $request)
    {
        return Report::select('id','client_id', 'date', 'people', 'hour', 'description', 'refer')->orderBy('date', 'DESC')
        ->where('user_id', auth()->user()->id)
        ->where('client_id', $request->id)
        ->get();
    }

    public function sendMail(StorereportRequest $req)
    {
       //$result = mail('mirkofenu@yahoo.it', $req->subject, $req->message);
       $mailTo = new ReportMail($req->message);
       $mailTo->from('tecmar@report.it');
       $mailTo->subject($req->subject);
       $result = Mail::to(auth()->user())->send($mailTo);
       return $this->getResult($req->message, $result, 'Mail Inviata');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorereportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorereportRequest $request)
    {
        $report = new Report();
        $report->user_id = auth()->user()->id;
        $report->client_id = $request->client_id ?? 1;
        $report->date = $request->date ?? '2000-01-01';
        $report->people = $request->people ?? 0;
        $report->hour = $request->hour ?? 0;
        $report->description = $request->description ?? 'Lorem Ipsum';
        $report->refer = $request->refer ?? '';

        $res= $report->save();

        return $this->getResult($report, $res, 'Report Creato');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(report $report)
    {
        return $this->getResult($report, true, '');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatereportRequest  $request
     * @param  \App\Models\report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatereportRequest $request, report $report)
    {
        $report->client_id = $request->client_id ?? $report->client_id;
        $report->date = $request->date ?? $report->date;
        $report->people = $request->people ?? $report->people;
        $report->hour = $request->hour ?? $report->hour;
        $report->description = $request->description ?? $report->description;
        $report->refer = $request->refer ?? $report->request;

        $res= $report->save();

        return $this->getResult($report, $res, 'Report Aggiornato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(report $report)
    {
        $res = $report->delete();
        return $this->getResult($report, $res, 'Report Cancellato');
    }
    private function getResult($data, $success, $message)
    {
        return [
            'data' => $data,
            'success' => $success,
            'message' => $message,
        ];
    }
}
