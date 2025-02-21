@extends('errors.layouts.main')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __($message ?? 'Unauthorized'))
