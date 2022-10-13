using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VTurnoDetalle : BDconexion
    {
        public List<ETurnoDetalle> Listar_TurnoDetalle(Int32 post, Int32 semana, Int32 local, Int32 anhio, String dni)
        {
            List<ETurnoDetalle> lCTurnoDetalle = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CTurnoDetalle oVTurnoDetalle = new CTurnoDetalle();
                    lCTurnoDetalle = oVTurnoDetalle.Listar_TurnoDetalle(con, post, semana, local, anhio, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCTurnoDetalle);
        }
    }
}