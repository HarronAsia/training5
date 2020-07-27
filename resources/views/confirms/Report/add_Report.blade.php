@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

        <div class="container">
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h4 class="modal-title text-light">Add Report</h4>
                    </div>

                    <div class="modal-body">

                        <form action="{{ route('thread.report.store',['threadid'=>$thread->id])}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(Auth::guest())
                            
                            <div class="form-group">
                                <div>
                                    <label for="name">Tên: </label>
                                    <input type="text" name="name" required>
                                </div>

                                <div>
                                    <label for="email">Email: </label>
                                    <input type="email" name="email" required>
                                </div>
                                
                            </div>
                            @else
                            <input type="hidden" name="name" value="{{Auth::user()->name}}">
                            <input type="hidden" name="email" value="{{Auth::user()->email}}">
                            
                            @endif
                            
                            <div class="form-group">
                                <ul>
                                    <label for="reason">Lý do: </label>
                                    <li>
                                        <input TYPE="radio" Name="reason" Value="Tiếng Việt không dấu">Tiếng Việt không dấu
                                    </li>

                                    <li>
                                        <input TYPE="radio" Name="reason" Value="Nội dung vi phạm nội quy">Nội dung vi phạm nội quy
                                    </li>

                                    <li>
                                        <input TYPE="radio" Name="reason" Value="Cố tình spam, làm loãng hoặc phá hỏng chủ đề của thành viên khác">Cố tình spam, làm loãng hoặc phá hỏng chủ đề của thành viên khác
                                    </li>

                                    <li>
                                        <input TYPE="radio" Name="reason" Value="Từ ngữ không tinh tế hay thô tục">Từ ngữ không tinh tế hay thô tục
                                    </li>

                                    <li>
                                        <input TYPE="radio" Name="reason" Value="Vi phạm bản quyền phần mềm">Vi phạm bản quyền phần mềm
                                    </li>

                                    <li>
                                        <input TYPE="radio" Name="reason" Value="Nôi dung liên quan hay bàn về chính trị">Nôi dung liên quan hay bàn về chính trị
                                    </li>

                                    <li>
                                        <input TYPE="radio" Name="reason" Value="Kích động, cố tình gây cãi nhau">Kích động, cố tình gây cãi nhau
                                    </li>

                                    <li>
                                        <input TYPE="radio" Name="reason" Value="Phá hoại chủ đề">Phá hoại chủ đề
                                    </li>

                                    <li>
                                        <input TYPE="radio" Name="reason" Value="Spam/Quảng cáo">Spam/Quảng cáo
                                    </li>

                                    <li>
                                        <input TYPE="radio" Name="reason" Value="Bóc tem, xé tem">Bóc tem, xé tem
                                    </li>

                                    <li>
                                        <input TYPE="radio" Name="reason" Value="Cố tình chửi nhau, xúc phạm nhau">Cố tình chửi nhau, xúc phạm nhau
                                    </li>
                                </ul>
                            </div>

                            <div class="form-group">
                                <label for="detail">Lý do thông báo xấu</label>
                                <textarea class="form-control" name = "detail" rows="7" style="min-width: 100% ;max-width: 100%; min-height: 200px ;max-height: 200px;" required></textarea>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="form-control form-control-lg" class="btn btn-success btn-block btn-lg">
                            </div>
                        </form>
                    </div>

                </div>


            </div>
        </div>

    </div>
</div>
@endsection