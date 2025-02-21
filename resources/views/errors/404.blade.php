@extends('errors.layouts.main')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __($message ?? 'Not Found'))
