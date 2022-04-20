{if $message != null}
    <div class="alert alert-success" role="alert">
    <p class="alert-text">{$message}</p>
    </div>
{else}
        <div class="alert alert-danger" role="alert">
    <p class="alert-text">{$message} is null</p>
    </div>
{/if}

<form action="" method="post">
<div class="form-group">
  <label class="form-control-label" for="input1">Normal input</label>
  <input type="text" class="form-control" required id="input1" />
</div>

<div class="form-group form-group-lg">
  <label class="form-control-label" for="courseRating">Course Rating</label>
  <input type="text" name="courserating" class="form-control form-control-lg" value='{$courserating}'' id="courseRating" />
</div>

<div class="form-group form-group-lg">
  <label class="form-control-label" for="input2">With placeholder</label>
  <input
    type="text"
    class="form-control form-control-lg"
    placeholder="A beautiful placeholder"
    id="input2"
  />
</div>
<div class="form-group form-group-lg">
<button type="submit" class="btn btn-success">Submit</button>
</div>
</form>