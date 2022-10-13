using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CConsultaPerfil
    {
        public List<EConsultaPerfil> Listar_ConsultaPerfil(SqlConnection con, String dni)
        {
            List<EConsultaPerfil> lEConsultaPerfil = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTA_PERFIL", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEConsultaPerfil = new List<EConsultaPerfil>();

                EConsultaPerfil obEConsultaPerfil = null;
                while (drd.Read())
                {
                    obEConsultaPerfil = new EConsultaPerfil();
                    obEConsultaPerfil.v_dni = drd["v_dni"].ToString();
                    obEConsultaPerfil.v_nombre = drd["v_nombre"].ToString();
                    obEConsultaPerfil.d_fnacimiento = drd["d_fnacimiento"].ToString();
                    obEConsultaPerfil.i_civil = drd["i_civil"].ToString();
                    obEConsultaPerfil.v_celular = drd["v_celular"].ToString();
                    obEConsultaPerfil.v_correo = drd["v_correo"].ToString();
                    obEConsultaPerfil.v_correo_empresa = drd["v_correo_empresa"].ToString();
                    obEConsultaPerfil.v_celular_sos = drd["v_celular_sos"].ToString();
                    obEConsultaPerfil.v_nombre_sos = drd["v_nombre_sos"].ToString();
                    obEConsultaPerfil.v_departamento = drd["v_departamento"].ToString();
                    obEConsultaPerfil.v_provincia = drd["v_provincia"].ToString();
                    obEConsultaPerfil.v_distrito = drd["v_distrito"].ToString();
                    obEConsultaPerfil.v_domicilio_actual = drd["v_domicilio_actual"].ToString();
                    obEConsultaPerfil.v_referencia = drd["v_referencia"].ToString();
                    lEConsultaPerfil.Add(obEConsultaPerfil);
                }
                drd.Close();
            }

            return (lEConsultaPerfil);
        }
    }
}