
# Campos Elvira Valeria - 186831

lista = [-12, -14, -5, 15, -8, -10, -12]
semana = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"]
listaord = sorted(lista)
cont = 0
for i in lista:
    cont += i

# a) Promedio
print("--------------------------------------------------------")
media = cont / len(lista)
print(f"La media es: {media:.3f}")
print("--------------------------------------------------------")

# b) Chinook
print(f"Dias que ocurre el Chinook")
for i in range (len(lista)):
    if (lista[i] <= 18 and lista[i] >= 12):
        print(semana[i], ":", lista[i])

# c) Media recortada
print("--------------------------------------------------------")
porcentaje = 30 #Valor de porcentaje lo podemos cambiar
longitud = len(listaord)
eliminar = int(longitud * porcentaje / 100)
print(f"Porcentaje tomado: {porcentaje}")
print(f"Datos eliminados en total: {eliminar*2}")
nueva_longitud = longitud - eliminar * 2
lista_recortada = []
medrecortada = 0
if (nueva_longitud > 0):
    for i in range(eliminar, longitud - eliminar):
        lista_recortada.append(listaord[i])

    for i in lista_recortada:
        medrecortada += i
    medrecortada = medrecortada / len(lista_recortada)
    print(f"Media recortada: {medrecortada:.3f}")
else:
    print("Error: El porcentaje es demasiado alto")
print("--------------------------------------------------------")

# d) Media o media recortada
# La media es buena para datos más precisos y bien distribuidos, mientras que la media recortada presenta mayor precisión para datos sesgados o valores atípicos.
# Como tenemos la presencia de un valor atípico nos conviene más el uso de la media recortada.