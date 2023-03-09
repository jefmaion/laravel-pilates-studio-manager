

<tr>
    <td class="p-3">
        <h5><strong>{{ $exerciceName }}</strong></h5>
        <p>{{ $comments }}</p>
        <p><a href="#">Excluir</a></p>

        <input type="hidden" name="exercice[{{ $exerciceId }}][exercice_id]" value="{{ $exerciceId }}">
        <input type="hidden" name="exercice[{{ $exerciceId }}][student_id]" value="{{ $studentId }}">
        <input type="hidden" name="exercice[{{ $exerciceId }}][comments]" value="{{ $comments }}">

    </td>
</tr>

