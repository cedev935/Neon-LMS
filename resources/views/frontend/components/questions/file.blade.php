<!-- <div class="mb-2">
    <div class="form-group">
    <label for="">Example file input</label>
    <input type="file" class="form-control-file" id="">
  </div>
</div> -->

<!-- <div class="mt-2">
      <img id="preview" src="" width="100%">
      <form id="user_type_image" action="" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
              <label class="form-label">Image</label>
              <input type="file" id="img"  class="form-control" name="file" accept="image/*">
              <input type="hidden" id="quiz_img" name="quiz_img" value="">
          </div>
      </form>
  </div>  -->
  <?php

if(isset($firstFontSize)){
    $firstFontSize = $firstFontSize;
}else{
    $firstFontSize = '';
}

if(isset($firstStyle)){
    $firstStyle = $firstStyle;
}else{
    $firstStyle = '';
}

if(isset($firstFamily)){
    $firstFamily = $firstFamily;
}else{
    $firstFamily = '';
}

if(isset($firstFontSize1)){
    $firstFontSize1 = $firstFontSize1;
}else{
    $firstFontSize1 = '';
}

if(isset($firstStyle1)){
    $firstStyle1 = $firstStyle1;
}else{
    $firstStyle1 = '';
}

if(isset($firstFamily1)){
    $firstFamily1 = $firstFamily1;
}else{
    $firstFamily1 = '';
}

?>

@php
    $content = json_decode($question->content);

    if (is_array($content) && isset($content[0]->number)) {
        $number_of_files = $content[0]->number;
    } else {
        $number_of_files = 0;
    }

    $btn_color= $question->color1 == NULL ? $question->color1 : $question->color1;
@endphp
<div class="mt-2">
    <form id="question_type_image" action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group file-input">
            <label class="form-label">File</label>
            <input type="file" style="width: fit-content;" id="files" class="form-control" name="files[]" accept=<?php $cont=$question->content;
                $obj = json_decode($cont,true);
                $val = @isset($obj[0]["file_acceptable_exts"]);
                if(isset($obj[0]["file_acceptable_exts"])){

                    $val = $obj[0]["file_acceptable_exts"];
                    if($val != ""){
                        for($i = 0 ; $i< count($val) ; $i ++){
                            echo ".".$val[$i];
                            if($i != count($val)-1)
                            echo ",";
                        }
                    }
                }
                    ;?> multiple>
            <input type="hidden" name="files" class="files_user" id="{{$question->id}}" value="">
            <input type="hidden" id="user_upload_file" name="user_upload_file" value="">
            <input type="hidden" id="file_q_id" name="user_upload_img" value="{{$question->id}}">
            <input type="hidden" id="num_files" name="num_files" value="{{$number_of_files}}">
            <input type="hidden" id="btn_color" name="num_files" value="{{$btn_color}}">
            <input type="hidden" id="font_style" name="num_files" value="{{$firstFontSize}}">
            
        </div>
    </form>
    <div id="preview">
    </div>
</div> 

<script>
    var filePath = `{{route('user_upload_files')}}`;
    // var image_defaultPath = `{{asset('uploads/storage/')}}`
    var image_defaultPath = `{{url('uploads/storage/')}}`
    $("body").append(`<style>#q_<?php echo $question->id ?> .form-label{<?php echo $firstFontSize ?>}</style>`)
</script>
