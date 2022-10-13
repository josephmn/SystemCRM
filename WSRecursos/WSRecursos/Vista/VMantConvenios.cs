using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantConvenios : BDconexion
    {
        public List<EMantenimiento> MantConvenios(
            Int32 post,
            Int32 id,
            Int32 condicion,
            String nombre,
            Int32 estado,
            String finicio,
            String ffin,
            String tarjeta,
            String ventana,
            String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantConvenios oVMantConvenios = new CMantConvenios();
                    lCEMantenimiento = oVMantConvenios.MantConvenios(con, post, id, condicion, nombre, estado, finicio, ffin, tarjeta, ventana, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}