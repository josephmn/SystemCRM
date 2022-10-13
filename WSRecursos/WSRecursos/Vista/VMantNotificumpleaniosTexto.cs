using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantNotificumpleaniosTexto : BDconexion
    {
        public List<EMantenimiento> MantNotificumpleaniosTexto(
            Int32 post,
            Int32 id,
            Int32 icumple,
            String texto,
            Int32 tamanio,
            String color,
            Int32 r,
            Int32 g,
            Int32 b,
            Int32 angulo,
            Int32 posicionx,
            Int32 posiciony,
            Int32 alineacion,
            String fuente,
            String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantNotificumpleaniosTexto oVMantNotificumpleaniosTexto = new CMantNotificumpleaniosTexto();
                    lCEMantenimiento = oVMantNotificumpleaniosTexto.MantNotificumpleaniosTexto(con, post, id, icumple, texto, tamanio, color, r, g, b, angulo, posicionx, posiciony, alineacion, fuente, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}