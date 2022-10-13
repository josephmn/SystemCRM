using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantPerfilPersonal : BDconexion
    {
        public List<EMantenimiento> MantPerfilPersonal(String dni, String nombre, String fnacimiento,
            Int32 civil, String celular, String correo, String correoempresa, String celularsos, String nombresos,
            String departamento, String provincia, String distrito, String domicilioactual, String referencia, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantPerfilPersonal oVMantPerfilPersonal = new CMantPerfilPersonal();
                    lCEMantenimiento = oVMantPerfilPersonal.MantPerfilPersonal(con, dni, nombre, fnacimiento, civil, celular, correo,
                        correoempresa, celularsos, nombresos, departamento, provincia, distrito, domicilioactual, referencia, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}