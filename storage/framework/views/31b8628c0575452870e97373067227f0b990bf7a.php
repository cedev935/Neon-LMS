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

 <div class="w-100">
    <?php if(isset($content->symbol)): ?>
        <?php if($content->symbol == "1"): ?>
        <div class="mb-2"  style="<?php echo 'font-size:'.$firstFontSize.';font-style:'.$firstStyle.';font-family:'.$firstFamily.';' ?>">
            Value in €
        </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(isset($content)): ?>
        <?php if(isset($content->type)==1): ?>
            <div class="mb-2 radiogroup cursorbar"><div class="d-flex">
                    <div class="minus text-center">
                        <i class="fas fa-minus" style="color: <?php echo e($question->color1 == NULL ? $lesson->color1 : $question->color1); ?>"></i> <br>
                    
                        <span id="max-val" style="color: <?php echo e($question->color2 == NULL ? $lesson->color2 : $question->color2); ?>;<?php echo 'font-size:'.$firstFontSize.';font-style:'.$firstStyle.';font-family:'.$firstFamily.';' ?>"><?php echo e($content->min_value); ?></span>

                    </div>
                    <div class="range-slider">
                        <div id="tooltip"></div>
                    <!-- <input name="range" class="rangeslider" type="range"     min="<?php echo e($content->min_value); ?>" max="<?php echo e($content->max_value); ?>" value="<?php echo e($content->min_value); ?>"> -->
                    <input name="b_range" class="" id="range" data-id="<?php echo e($question->id); ?>" type="range" min="<?php echo e($content->min_value); ?>" step="<?php echo e($content->steps); ?>" max="<?php echo e($content->max_value); ?>" value="<?php echo e($content->min_value); ?>">
                    <script>$("body").append(`<style>#q_<?php echo $question->id?> #range::-webkit-slider-runnable-track{background: <?php echo $question->color1 == NULL ? $lesson->color1 : $question->color1 ?>} #q_<?php echo $question->id?> #range::-moz-range-track {background: <?php echo $question->color1 == NULL ? $lesson->color1 : $question->color1 ?>} #q_<?php echo $question->id?> #tooltip span{border-color:<?php echo $question->color1 == NULL ? $lesson->color1 : $question->color1 ?>;color: <?php echo e($question->color2 == NULL ? $lesson->color2 : $question->color2); ?>;<?php echo 'font-size:'.$firstFontSize.';font-style:'.$firstStyle.';font-family:'.$firstFamily.';' ?>;} #q_<?php echo $question->id?> #tooltip span::before{border-top-color:<?php echo $question->color1 == NULL ? $lesson->color1 : $question->color1 ?>}  #q_<?php echo $question->id?> input[type=range]::-webkit-slider-thumb{border-color:<?php echo $question->color1 == NULL ? $lesson->color1 : $question->color1 ?>}  #q_<?php echo $question->id?> input[type=range]::-moz-range-thumb{border-color:<?php echo $question->color1 == NULL ? $lesson->color1 : $question->color1 ?>}</style>`)</script>
                    <!-- <div class="range-output text-center">
                        <output class="output" name="output" for="range">
                        <?php echo e($content->min_value); ?>

                        </output>
                    </div> -->
                    </div>
                    <div class="plus text-center">
                        <i class="fas fa-plus" style="color: <?php echo e($question->color1 == NULL ? $lesson->color1 : $question->color1); ?>"></i> <br>
                        <span id="min-val" style="color: <?php echo e($question->color2 == NULL ? $lesson->color2 : $question->color2); ?>;<?php echo 'font-size:'.$firstFontSize.';font-style:'.$firstStyle.';font-family:'.$firstFamily.';' ?>"><?php echo e($content->max_value); ?></span>
                    </div>
                </div>
            </div>
        
        <?php else: ?>
            <div class="mb-2 radiogroup cursorbar btns"><div class="d-flex">
                    <button type="button" class="minus btn-minus text-center">
                        -
                    </button>
                    <div class="input-range">
                        <input name="b_range" id="<?php echo e($question->id); ?>" type="number" class="form-control rangevalue" min="<?php echo e($content->min_value); ?>" step="<?php echo e($content->steps); ?>" max="<?php echo e($content->max_value); ?>" value="<?php echo e($content->min_value); ?>" <?php if($content->symbol=="1"): ?> step="any" <?php endif; ?>>
                    </div>
                    <button type="button" class="plus btn-plus text-center">
                        +
                    </button>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<script type="text/javascript">
    // $(document).ready(function(){
    //     console.log($("#ragne_col").val());
    //     var css = `#range::-webkit-range-track { background:${$("#ragne_col").val()}`;
    //     var style = document.createElement('style');

    //     if (style.styleSheet) {
    //         style.styleSheet.cssText = css;
    //     } else {
    //         style.appendChild(document.createTextNode(css));
    //     }

    //     document.getElementsByTagName('head')[0].appendChild(style);
    // })
</script><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/components/questions/rangs.blade.php ENDPATH**/ ?>