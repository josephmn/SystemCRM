using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantPagovacaciones : BDconexion
    {
        public List<EMantenimiento> MantPagovacaciones(
            Int32 post, 
            Int32 mes, 
            Int32 anhio, 
            String fecha,
            Int32 ivac,
            String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantPagovacaciones oVMantPagovacaciones = new CMantPagovacaciones();
                    lCEMantenimiento = oVMantPagovacaciones.MantPagovacaciones(con, post, mes, anhio, fecha, ivac, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}