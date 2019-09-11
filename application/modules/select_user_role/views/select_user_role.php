<style type="text/css">
  .modal-backdrop
{
    opacity:1 !important;
}
</style>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-danger">

        <h4 class="modal-title">Select Your Role</h4>
        
      </div>
      <div class="modal-body">
        <form method="post" id="select_role" action="<?php echo base_url('select_user_role'); ?>" autocompleate="off">
          <div class="form-group row" id="for_append">
            <label class="control-label col-md-4 text-right pt-2">Log in as :
              <span class="required">  </span>
            </label>
            <div class="col-md-5">
              <?php 
                $options['']  = 'Select Role';
                foreach((array)$roles as $role){
                  $options[$role->role_id] = $role->role_name;
                }
                if ( count( $role_count ) == 1 ) 
                {
                  $css = array(
                          'id'       => 'user_role',
                          'class'    => 'form-control input-height',
                          'disabled' => '1'
                  ); 
                  echo form_dropdown('user_role', $options, $roles[0]->role_id, $css);
                }
                else
                {
                  $css = array(
                          'id'       => 'user_role',
                          'class'    => 'form-control input-height',
                          
                  );

                  echo form_dropdown('user_role', $options, '', $css);
                }
              ?>
            </div>
          </div>

          <input type="hidden" name="region_id" id="region_id">
          <input type="hidden" name="site_id" id="site_id">

          <!-- <div class="form-group row" id="region_div" style="display: none;">
             <label class="control-label col-md-4 text-right pt-2">Region 
              <span class="required"> * </span> 
            </label>
            <div class="col-md-5">
              <select class="form-control input-height" id="region"></select>
            </div>
          </div> -->

          <div class="form-group row" id="region_div" >
             <label class="control-label col-md-4 text-right pt-2">Region 
              <span class="required" id="region_requaired"> * </span> 
            </label>
            <div class="col-md-5">
              <select class="form-control input-height" id="region">
                <option value="">Select Region</option>
              </select>
            </div>
          </div>
          
          <div class="form-group row" id="site_div" >
             <label class="control-label col-md-4 text-right pt-2">Site 
              <span class="required" id="site_requaired"> * </span> 
            </label>
            <div class="col-md-5">
              <select class="form-control input-height" id="site">
                <option value="">Select Site</option>
              </select>
            </div>
          </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary mx-auto">Select</button>
                <?php if ( array_key_exists('from', $_GET) ) : ?>
                  <a href="<?php echo (base_url('logout')) ?>" class="btn btn-danger mx-auto">Cancel</a>
                <?php else : ?>
                  <a href="javascript:window.history.back();" class="btn btn-danger mx-auto">Cancel</a>
                <?php endif; ?>
            </div>


         
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
    $(window).on('load',function(){

        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#myModal').modal('show');
    });

    
    $(document).ready(function(){
      $( "#select_role" ).validate({
        ignore: "",
        rules: {
          user_role: {
                required: true
            },
        }
      });
      
      $('#region').rules("add", 
      {
          required: true,
      });

      $('#site').rules("add", 
      {
          required: true,
      });

    <?php if ( count( $role_count ) == 1 ) : ?>
      // alert();
      $('#user_role').trigger('change');  
    <?php endif; ?>
    });

    $('#user_role').change(function(){
      // alert($(this).val());
      $('#region_id')
      $.ajax
      ({
        type: "POST",
        url: "<?php echo base_url('select_user_role/find_region_site');?>",
        data: {
          role_id : $(this).val(),
          user_id : "<?php echo $this->session->userdata( 'user_id' );?>"
        },
        cache: false,
        dataType: "JSON",
        success: function(data)
        {
          if ( data.success ) 
          {
            // if ( data.result.length > 1 ) 
            // {
              var htm = "";
              htm += '<option value="">Select Region</option>';
              $.each( data.result, function( key, value ) {
                //alert( key + ": " + value );
                // console.log(value.region_name);
                htm += '<option value="'+value.region_id+'">'+value.region_name+'</option>';
              });
              $('#region').html(htm);
              $('#region_div').show(); 
              
              htm1 = "";
              htm1 += '<option value="">Select Site</option>';
              $('#site').html(htm1);
            // }
            // else
            // {
            //   <?php //if ( count( $region_count ) == 1 ) : ?>
            //     $('#region_div').show();
            //     var htm = "";
            //     htm += '<option value="">Select Region</option>';
            //     $.each( data.result, function( key, value ) {
            //       //alert( key + ": " + value );
            //       // console.log(value.region_name);
            //       htm += '<option value="'+value.region_id+'" selected>'+value.region_name+'</option>';
            //     });
            //     $('#region').html(htm);
            //     $('#region_div').show();
            //     $('#region').attr('disabled',true);
            //     $('#region').rules("add", 
            //     {
            //         required: true,
            //         /*messages: {
            //             required: "Region is required",
            //         }*/
            //     });
            //     $('#region').trigger('change');  
            //   <?php //else: ?>
            //   $('#region_div').hide(); 
            //   $('#site_div').hide();
            //   $('#region_id').val( data.result[0].region_id );
            //   $('#site_id').val( data.result[0].site_id );
            //   <?php //endif; ?>
            // }
          }
          
        } 
      });
      
        if ( $(this).val() == 7 ) 
        {
          $('#site').rules("remove"); 
          $('#site_requaired').hide();
          $('#region_requaired').show();

          $('#region').rules("add", 
          {
              required: true,
          });
        }
        else if( $(this).val() == 1 )
        {
          $('#site').rules("remove");
          $('#region').rules("remove");
          $('#site_requaired').hide();
          $('#region_requaired').hide();
        }
        else
        {
          $('#region_requaired').show();

          $('#region').rules("add", 
          {
              required: true,
          });
          
          $('#site').rules("add", 
          {
              required: true,
          }); 

          $('#site_requaired').show(); 
        }
      
    });

     $('#region').change(function(){
      // alert($(this).val());
      $('#region_id').val($(this).val());
      $.ajax
      ({
        type: "POST",
        url: "<?php echo base_url('select_user_role/find_region_site');?>",
        data: {
          role_id : $('#user_role').val(),
          user_id : "<?php echo $this->session->userdata( 'user_id' );?>",
          region_id : $(this).val()
        },
        cache: false,
        dataType: "JSON",
        success: function(data)
        {
          if ( data.success ) 
          {
            // if ( data.result.length > 1 ) 
            // {
              var htm = "";
              htm += '<option value="">Select Site</option>';
              $.each( data.result, function( key, value ) {
                //alert( key + ": " + value );
                // console.log(value.region_name);
                htm += '<option value="'+value.site_id+'">'+value.site_name+'</option>';
              });
              $('#site').html(htm);
              $('#site_div').show();
              $('#site').rules("add", 
              {
                  required: true,
                  /*messages: {
                      required: "Site is required",
                  }*/
              }); 
            // }
            // else
            // {

            //   $('#site_div').hide(); 
            //   $('#site_id').val( data.result[0].site_id );
            // }
          }
          
        } 
      });
    });

    $('#site').change(function(){
      // console.log($('#site').closest("form"));
      $('#site_id').val( $(this).val() );
    });

    $('#select_role').submit(function(e){
      if ( $('#user_role').val() == 1 ) 
      {
        $('#user_role').attr('disabled',false);
        $('#region').attr('disabled',false);
      }
      else
      {
        if($('#site').is(":visible"))
        {
          if($('#site').val() == '')
          {
            if ( $('#user_role').val() != 7 ) 
            {
              alert('Please select all manadatory feilds');
              e.preventDefault();
              return;
            }
          }
          else
          {
            $('#user_role').attr('disabled',false);
            $('#region').attr('disabled',false);
          }
        }
        else
        {
          $('#user_role').attr('disabled',false);
          $('#region').attr('disabled',false);
        }
      }
    });
</script>