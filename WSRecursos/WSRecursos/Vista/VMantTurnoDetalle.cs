using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantTurnoDetalle : BDconexion
    {
        public List<EMantenimiento> MantTurnoDetalle(Int32 post, String dni, String dia, Int32 semana, Int32 anhio, String horainicio, String horafin, String tolerancia, Int32 local, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantTurnoDetalle oVMantTurnoDetalle = new CMantTurnoDetalle();
                    lCEMantenimiento = oVMantTurnoDetalle.MantTurnoDetalle(con, post, dni, dia, semana, anhio, horainicio, horafin, tolerancia, local, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}