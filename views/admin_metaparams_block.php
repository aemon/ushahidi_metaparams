<div class="metaparamsadminlist">
    <?php
     foreach ($fields_list as $locale=>$fields){?>
    <?php foreach ($fields as $type=>$original){?>
        <div class="<?=$type;?>">
            <?=$locale.' '.$type;?>
            <textarea  name="<?=$locale.'_'.$type;?>" id="<?=$locale.'_'.$type;?>"><?=((!empty($set_metaparams[$locale.'_'.$type]))?$set_metaparams[$locale.'_'.$type]:'');?></textarea>
            <button class="" onclick="generate_<?=$type;?>('#<?=$locale.'_'.$type;?>','#<?=$original;?>');return false;">Generate</button>
        </div>
    <?php }?>
    <?php }?>
    
    <script type="text/javascript">
    function implode( delimer, arr ) {
        return ( ( arr instanceof Array ) ? arr.join ( delimer ) : arr );
    }

    function strrpos( haystack, needle, offset){
        i = haystack.lastIndexOf( needle, offset ); 
        return i >= 0 ? i : false;
    }
    
    function generate_keywords(id_keywords, id_title){
      keywords = new Array;  
      title_words = jQuery(id_title).val().split(' ');  
      for (i=0;((keywords.length<=4)&&(i<title_words.length));i++){
          if (title_words[i].length>=5){
            keywords.push(title_words[i]);    
          }
      }
      jQuery(id_keywords).val(implode(', ',keywords));
      return false;
        
    }    
    
    function generate_description(id_description, id_original_description){
        val_description = jQuery(id_original_description).val().substring(0,128);
        jQuery(id_description).val(val_description.substring(0, val_description.lastIndexOf(' ')));
        return false;
    }
    </script>
</div>