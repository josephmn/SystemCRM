using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VGestionVacaciones : BDconexion
    {
        public List<EMantenimiento> Listar_GestionVacaciones(Int32 codigo, String dni, Int32 indice)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CGestionVacaciones oVGestionVacaciones = new CGestionVacaciones();
                    lCEMantenimiento = oVGestionVacaciones.Listar_GestionVacaciones(con, codigo, dni, indice);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}