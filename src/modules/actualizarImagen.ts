/**
 * Esta funciona vigila un cambio de imagen y valida si cumple algunos requisitos:
 *
 * - La imagen sólo puede tener formato JPG o PNG
 * - La imagen sólo puede tener un tamaño menor a 2 megabytes
 */
export default function actualizarImagen(
  inputFile: HTMLInputElement,
  img: HTMLImageElement,
  onError: (error?: string) => void = () => {},
) {
  inputFile.onchange = () => {
    const files = inputFile.files;

    if (!files) {
      return onError("No se ha seleccionado ningún archivo");
    }

    const [file] = files;

    if (
      file.type !== "image/jpeg" &&
      file.type !== "image/jpg" &&
      file.type !== "image/png"
    ) {
      return onError("Sólo se permiten imagenes JPG y PNG");
    }

    if (file.size > 1 * 1000 * 1024 * 2) {
      /*1b * 1000 = 1kb * 1024 = 1mb * 2 = :D*/
      return onError("La imagen no puede ser mayor a 2MB");
    }

    const fileReader = new FileReader();
    fileReader.readAsDataURL(file);

    fileReader.onload = () => {
      const { result } = fileReader;

      if (!result) {
        return onError("Error al leer el archivo");
      }

      img.setAttribute("src", result.toString());

      return onError();
    };
  };
}
