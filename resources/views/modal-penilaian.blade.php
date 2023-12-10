<div class="modal fade" id="penilaianApp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-main text-white pb-4">
          <h5 class="modal-title" id="exampleModalLabel">Penilaian App</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form action="penilaian-app" method="post">
            @csrf

            @php
                $questions = DB::table('ulasan_pertanyaan')->get(); 
             @endphp

            @foreach($questions as $key => $question)
            <label for="question{{ $key}}" class="mt-1 font-weight-bold">{{ $key+1 }}. {{ $question->nama }}</label>   
            <input type="hidden" name="question{{ $key}}" value="{{$question->id}}"> 
            <div>
                <input type="radio" id="sangat_baik{{ $key}}" name="answer{{ $key}}" value="Sangat Baik">
                <label for="sangat_baik{{ $key}}">Sangat Baik</label>
            </div>
            <div>
                <input type="radio" id="baik{{ $key}}" name="answer{{ $key}}" value="Baik">
                <label for="baik{{ $key}}">Baik</label>
            </div>
            <div>
                <input type="radio" id="cukup{{ $key}}" name="answer{{ $key}}" value="Cukup">
                <label for="cukup{{ $key}}">Cukup</label>
            </div>
            <div>
                <input type="radio" id="kurang{{ $key}}" name="answer{{ $key}}" value="Kurang">
                <label for="kurang{{ $key}}">Kurang</label>
            </div>
            <div>
                <input type="radio" id="sangat_kurang{{ $key}}" name="answer{{ $key}}" value="Sangat Kurang">
                <label for="sangat_kurang{{ $key}}">Sangat Kurang</label>
            </div>
            @endforeach
            <div class="modal-footer w-100 px-0">
                <button type="submit" class="btn btn-primary w-100">Kirim Penilaian</button>
              </div>
          </form>
        </div>
        
      </div>
    </div>
  </div>